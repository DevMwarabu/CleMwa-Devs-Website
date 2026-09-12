<?php

namespace App\Console\Commands;

use App\Models\AlertEvent;
use App\Models\AlertRule;
use App\Models\AlertState;
use App\Models\NotificationDelivery;
use App\Models\NotificationPolicy;
use App\Models\NotificationSetting;
use App\Models\Server;
use App\Support\MetricRangeQuery;
use App\Support\NotificationDispatcher;
use Illuminate\Console\Command;

class EvaluateAlertRules extends Command
{
    protected $signature = 'alerts:evaluate';

    protected $description = 'Evaluate all enabled alert rules and dispatch notifications for anything notification-worthy';

    private const METRIC_KEYS = ['cpu_percent', 'memory_percent', 'disk_percent'];

    /** @var int[] AlertEvent ids created during this run */
    private array $newEventIds = [];

    public function handle(): int
    {
        // Reset per invocation — Laravel's console Application can reuse a
        // resolved command instance across multiple calls in one process
        // (e.g. repeated $this->artisan() in a single test), unlike a real
        // cron tick which always starts a fresh process.
        $this->newEventIds = [];

        $rules = AlertRule::where('enabled', true)->get();
        $evaluated = 0;

        foreach ($rules as $rule) {
            $servers = $rule->server_id
                ? Server::where('id', $rule->server_id)->get()
                : Server::all();

            foreach ($servers as $server) {
                $result = $this->evaluate($rule, $server);
                if ($result === null) {
                    continue; // no data to evaluate against — skip, don't fabricate
                }

                $this->transition($rule, $server, $result['breached'], $result['value']);
                $evaluated++;
            }
        }

        $this->info("Evaluated {$evaluated} rule/server pair(s).");

        $sent = $this->dispatchNotifications();
        $this->info("Sent {$sent} notification(s).");

        return self::SUCCESS;
    }

    /**
     * Returns ['breached' => bool, 'value' => ?float] or null when there's
     * no data to evaluate this rule against yet (e.g. a metric rule against
     * a server that hasn't reported any metrics).
     */
    private function evaluate(AlertRule $rule, Server $server): ?array
    {
        if ($rule->metric === 'server_offline') {
            return ['breached' => $server->status === 'offline', 'value' => null];
        }

        if ($rule->metric === 'service_down') {
            $server->loadMissing('metric');
            $services = $server->metric?->services;
            if ($services === null) {
                return null;
            }
            $entry = collect($services)->firstWhere('name', $rule->service_name);
            $breached = $entry === null || ! ($entry['active'] ?? false);

            return ['breached' => $breached, 'value' => null];
        }

        if (in_array($rule->metric, self::METRIC_KEYS, true)) {
            $server->loadMissing('metric');
            if (! $server->metric) {
                return null;
            }

            $percentages = MetricRangeQuery::extractPercentages(
                json_encode($server->metric->cpu),
                json_encode($server->metric->memory),
                json_encode($server->metric->disk),
            );
            $value = $percentages[$rule->metric] ?? null;
            if ($value === null) {
                return null;
            }

            return ['breached' => $this->compare($value, $rule->condition, (float) $rule->threshold), 'value' => $value];
        }

        return null;
    }

    private function compare(float $value, string $condition, float $threshold): bool
    {
        return match ($condition) {
            '>' => $value > $threshold,
            '<' => $value < $threshold,
            '>=' => $value >= $threshold,
            '<=' => $value <= $threshold,
            default => false,
        };
    }

    private function transition(AlertRule $rule, Server $server, bool $breached, ?float $value): void
    {
        $state = AlertState::firstOrCreate(
            ['alert_rule_id' => $rule->id, 'server_id' => $server->id],
            ['state' => 'normal']
        );

        $from = $state->state;
        $now = now();

        if ($breached) {
            if (in_array($from, ['normal', 'resolved'], true)) {
                $state->update(['state' => 'pending', 'breach_started_at' => $now, 'current_value' => $value, 'last_evaluated_at' => $now]);
            } elseif ($from === 'pending') {
                $state->current_value = $value;
                $state->last_evaluated_at = $now;
                if ($state->breach_started_at->diffInSeconds($now) >= $rule->for_duration_seconds) {
                    $state->state = 'firing';
                    $state->fired_at = $now;
                    $state->save();
                    $this->logEvent($rule, $server, 'pending', 'firing', $value, $now);
                } else {
                    $state->save();
                }
            } else { // already firing
                $state->update(['current_value' => $value, 'last_evaluated_at' => $now]);
            }
        } else {
            if (in_array($from, ['pending', 'firing'], true)) {
                $state->update([
                    'state' => 'resolved',
                    'resolved_at' => $now,
                    'breach_started_at' => null,
                    'current_value' => $value,
                    'last_evaluated_at' => $now,
                ]);
                $this->logEvent($rule, $server, $from, 'resolved', $value, $now);
            } else {
                $state->update(['current_value' => $value, 'last_evaluated_at' => $now]);
            }
        }
    }

    private function logEvent(AlertRule $rule, Server $server, string $from, string $to, ?float $value, $occurredAt): void
    {
        $event = AlertEvent::create([
            'alert_rule_id' => $rule->id,
            'server_id' => $server->id,
            'from_state' => $from,
            'to_state' => $to,
            'value_at_transition' => $value,
            'occurred_at' => $occurredAt,
        ]);

        $this->newEventIds[] = $event->id;
    }

    // -----------------------------------------------------------------
    // Notifications
    // -----------------------------------------------------------------

    /**
     * Collects notification-worthy alert states, resolves channels via
     * NotificationPolicy, groups by (server, channel), sends, and logs.
     * Returns the number of delivery attempts made (success or failure).
     */
    private function dispatchNotifications(): int
    {
        $items = $this->collectNotifiableItems();
        if (empty($items)) {
            return 0;
        }

        $settings = NotificationSetting::getSettings();
        $groups = [];

        foreach ($items as $item) {
            /** @var AlertState $state */
            $state = $item['state'];
            if ($state->isSilenced()) {
                continue; // tracked, visible in the UI, just not notified
            }

            $policy = NotificationPolicy::resolveFor($item['rule']->severity, $item['server']);
            if (! $policy || empty($policy->channels)) {
                continue; // no policy match — safe default is no notification
            }

            foreach ($policy->channels as $channel) {
                $key = $item['server']->id.':'.$channel;
                $groups[$key]['server'] = $item['server'];
                $groups[$key]['channel'] = $channel;
                $groups[$key]['items'][] = $item;
            }
        }

        $attempts = 0;
        foreach ($groups as $group) {
            $this->sendGroup($settings, $group);
            $attempts++;
        }

        return $attempts;
    }

    /**
     * @return array<int, array{rule: AlertRule, server: Server, state: AlertState, event_id: ?int}>
     */
    private function collectNotifiableItems(): array
    {
        $items = [];

        if (! empty($this->newEventIds)) {
            $events = AlertEvent::with(['rule', 'server'])
                ->whereIn('id', $this->newEventIds)
                ->whereIn('to_state', ['firing', 'resolved'])
                ->get();

            foreach ($events as $event) {
                $state = AlertState::where('alert_rule_id', $event->alert_rule_id)->where('server_id', $event->server_id)->first();
                if ($state) {
                    $items[] = ['rule' => $event->rule, 'server' => $event->server, 'state' => $state, 'event_id' => $event->id];
                }
            }
        }

        $handledStateIds = collect($items)->pluck('state.id')->all();

        $repeating = AlertState::with(['rule', 'server'])
            ->where('state', 'firing')
            ->whereNotIn('id', $handledStateIds ?: [0])
            ->get()
            ->filter(function (AlertState $state) {
                $interval = $state->rule?->notification_repeat_interval_seconds;
                if (! $interval) {
                    return false; // no repeat configured — already notified once at firing time
                }

                return ! $state->last_notified_at || $state->last_notified_at->diffInSeconds(now()) >= $interval;
            });

        foreach ($repeating as $state) {
            $latestFiringEvent = AlertEvent::where('alert_rule_id', $state->alert_rule_id)
                ->where('server_id', $state->server_id)
                ->where('to_state', 'firing')
                ->latest('occurred_at')
                ->first();

            $items[] = ['rule' => $state->rule, 'server' => $state->server, 'state' => $state, 'event_id' => $latestFiringEvent?->id];
        }

        return $items;
    }

    private function sendGroup(NotificationSetting $settings, array $group): void
    {
        $server = $group['server'];
        $channel = $group['channel'];
        $items = $group['items'];
        $eventIds = array_values(array_filter(array_map(fn ($i) => $i['event_id'], $items)));

        // Best-effort display value for the log only — must never throw here;
        // the real "is this channel actually configured" guard lives inside
        // sendEmailGroup()/sendTelegramGroup(), wrapped by the retry below.
        $recipient = $channel === 'telegram'
            ? $settings->telegram_chat_id
            : (string) $settings->alert_email_recipients;

        $delivery = [
            'channel' => $channel,
            'server_id' => $server->id,
            'alert_event_ids' => $eventIds,
            'recipient' => $recipient,
            'attempted_at' => now(),
            'retry_count' => 0,
        ];

        [$status, $error, $retryCount] = $this->attemptWithOneRetry(function () use ($settings, $channel, $server, $items) {
            if ($channel === 'telegram') {
                $this->sendTelegramGroup($settings, $server, $items);
            } else {
                $this->sendEmailGroup($settings, $server, $items);
            }
        });

        $delivery['status'] = $status;
        $delivery['error'] = $error;
        $delivery['retry_count'] = $retryCount;
        $delivery['delivered_at'] = $status === 'delivered' ? now() : null;

        NotificationDelivery::create($delivery);

        foreach ($items as $item) {
            $item['state']->update(['last_notified_at' => now()]);
        }
    }

    /**
     * @return array{0: string, 1: ?string, 2: int} [status, error, retryCount]
     */
    private function attemptWithOneRetry(\Closure $send): array
    {
        for ($attempt = 0; $attempt <= 1; $attempt++) {
            try {
                $send();

                return ['delivered', null, $attempt];
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                if ($attempt === 1) {
                    return ['failed', $error, $attempt];
                }
            }
        }

        return ['failed', $error ?? 'Unknown error', 1];
    }

    private function emailRecipients(NotificationSetting $settings): array
    {
        if (! $settings->smtp_enabled || ! $settings->smtp_host) {
            throw new \RuntimeException('SMTP is not configured.');
        }

        $recipients = array_filter(array_map('trim', explode(',', (string) $settings->alert_email_recipients)));
        if (empty($recipients)) {
            throw new \RuntimeException('No alert email recipients configured.');
        }

        return $recipients;
    }

    private function sendEmailGroup(NotificationSetting $settings, Server $server, array $items): void
    {
        $recipients = $this->emailRecipients($settings);
        $firing = collect($items)->where('state.state', 'firing');
        $subject = count($items) > 1
            ? count($items).' alerts on '.$server->name
            : $items[0]['rule']->name.' — '.strtoupper($items[0]['state']->state).' on '.$server->name;

        $body = "Server: {$server->name}\n\n";
        foreach ($items as $item) {
            $body .= $this->alertBlock($item)."\n";
        }
        $body .= "\nDashboard: {$this->dashboardUrl($server)}\n";

        NotificationDispatcher::sendEmail($settings, $recipients, $subject, $body);
    }

    private function sendTelegramGroup(NotificationSetting $settings, Server $server, array $items): void
    {
        if (! $settings->telegram_enabled || ! $settings->telegram_bot_token || ! $settings->telegram_chat_id) {
            throw new \RuntimeException('Telegram is not configured.');
        }

        $header = count($items) > 1
            ? "\u{1F6A8} SERVER ALERT — ".count($items)." alerts on {$server->name}\n\n"
            : "\u{1F6A8} SERVER ALERT\n\n";

        $text = $header;
        foreach (array_slice($items, 0, 20) as $item) {
            $text .= $this->alertBlock($item)."\n";
        }
        if (count($items) > 20) {
            $text .= '+'.(count($items) - 20)." more\n";
        }
        $text .= "\nDashboard: {$this->dashboardUrl($server)}";

        // Telegram's hard message cap is 4096 characters.
        if (strlen($text) > 4000) {
            $text = substr($text, 0, 3980)."\n… (truncated)";
        }

        NotificationDispatcher::sendTelegram($settings, $text);
    }

    private function alertBlock(array $item): string
    {
        $rule = $item['rule'];
        $state = $item['state'];

        $duration = $state->fired_at
            ? $state->fired_at->diffForHumans(now(), true)
            : 'n/a';

        return implode("\n", array_filter([
            'Alert: '.$rule->name,
            'Severity: '.strtoupper($rule->severity),
            'Status: '.strtoupper($state->state),
            $state->current_value !== null ? 'Current: '.$state->current_value : null,
            'Duration: '.$duration,
            'Time: '.now()->format('Y-m-d H:i').' '.config('app.timezone'),
        ]));
    }

    private function dashboardUrl(Server $server): string
    {
        $frontendUrl = rtrim((string) env('FRONTEND_URL', ''), '/');

        return $frontendUrl ? "{$frontendUrl}/servers/{$server->id}" : "(configure FRONTEND_URL to link here) server #{$server->id}";
    }
}

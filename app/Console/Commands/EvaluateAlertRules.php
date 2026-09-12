<?php

namespace App\Console\Commands;

use App\Models\AlertEvent;
use App\Models\AlertRule;
use App\Models\AlertState;
use App\Models\Server;
use App\Support\MetricRangeQuery;
use Illuminate\Console\Command;

class EvaluateAlertRules extends Command
{
    protected $signature = 'alerts:evaluate';

    protected $description = 'Evaluate all enabled alert rules against current server state and metrics';

    private const METRIC_KEYS = ['cpu_percent', 'memory_percent', 'disk_percent'];

    public function handle(): int
    {
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
        AlertEvent::create([
            'alert_rule_id' => $rule->id,
            'server_id' => $server->id,
            'from_state' => $from,
            'to_state' => $to,
            'value_at_transition' => $value,
            'occurred_at' => $occurredAt,
        ]);
    }
}

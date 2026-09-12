<?php

namespace Tests\Feature\Alerts;

use App\Models\AlertRule;
use App\Models\AlertSilence;
use App\Models\AlertState;
use App\Models\AuditLog;
use App\Models\NotificationDelivery;
use App\Models\NotificationPolicy;
use App\Models\NotificationSetting;
use App\Models\Server;
use App\Models\ServerMetric;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NotificationDispatchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
        Carbon::setTestNow(now());
        Mail::fake(); // intercepts Mail::mailer('monitoring_smtp') too — no real SMTP connection is attempted
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    private function configureEmailSettings(): void
    {
        NotificationSetting::getSettings()->update([
            'smtp_enabled' => true,
            'smtp_host' => 'smtp.example.com',
            'smtp_username' => 'alerts@example.com',
            'alert_email_recipients' => 'ops@example.com',
        ]);
    }

    private function serverWithCpu(float $usagePercent, string $environment = 'production'): Server
    {
        $server = Server::create(['name' => 'notify-target', 'environment' => $environment]);
        ServerMetric::create(['server_id' => $server->id, 'cpu' => ['usage_percent' => $usagePercent], 'collected_at' => now()]);

        return $server;
    }

    public function test_no_matching_policy_sends_nothing(): void
    {
        $this->configureEmailSettings();
        $this->serverWithCpu(95);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'critical']);

        $this->artisan('alerts:evaluate'); // -> pending
        $this->artisan('alerts:evaluate'); // -> firing, no policy exists at all

        $this->assertSame(0, NotificationDelivery::count());
    }

    public function test_matching_policy_sends_email_and_logs_delivery(): void
    {
        $this->configureEmailSettings();
        NotificationPolicy::create(['name' => 'critical-prod', 'priority' => 1, 'severity' => 'critical', 'environment' => 'production', 'channels' => ['email']]);

        $this->serverWithCpu(95);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'critical']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        $this->assertSame(1, NotificationDelivery::count());
        $delivery = NotificationDelivery::first();
        $this->assertSame('email', $delivery->channel);
        $this->assertSame('delivered', $delivery->status);
        $this->assertNotEmpty($delivery->alert_event_ids);
    }

    public function test_first_matching_policy_by_priority_wins(): void
    {
        $this->configureEmailSettings();
        NotificationPolicy::create(['name' => 'catch-all', 'priority' => 100, 'severity' => null, 'environment' => null, 'channels' => ['email']]);
        NotificationPolicy::create(['name' => 'critical-first', 'priority' => 1, 'severity' => 'critical', 'environment' => null, 'channels' => []]);

        $this->serverWithCpu(95);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'critical']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        // The priority-1 policy matches first and routes to no channels ("dashboard only") — nothing sent.
        $this->assertSame(0, NotificationDelivery::count());
    }

    public function test_silenced_alert_never_gets_notified(): void
    {
        $this->configureEmailSettings();
        NotificationPolicy::create(['name' => 'any', 'priority' => 1, 'channels' => ['email']]);

        $server = $this->serverWithCpu(95);
        $rule = AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'warning']);

        AlertSilence::create([
            'alert_rule_id' => $rule->id, 'server_id' => $server->id, 'reason' => 'known',
            'starts_at' => now()->subMinute(), 'ends_at' => now()->addHour(),
        ]);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        $this->assertSame('firing', AlertState::first()->state);
        $this->assertSame(0, NotificationDelivery::count());
    }

    public function test_two_alerts_on_same_server_same_channel_are_grouped_into_one_delivery(): void
    {
        $this->configureEmailSettings();
        NotificationPolicy::create(['name' => 'any', 'priority' => 1, 'channels' => ['email']]);

        $server = Server::create(['name' => 'multi-alert-server']);
        ServerMetric::create([
            'server_id' => $server->id,
            'cpu' => ['usage_percent' => 95],
            'memory' => ['total_mb' => 1000, 'used_mb' => 950],
            'collected_at' => now(),
        ]);

        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'warning']);
        AlertRule::create(['name' => 'high mem', 'metric' => 'memory_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'warning']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        $this->assertSame(1, NotificationDelivery::count());
        $this->assertCount(2, NotificationDelivery::first()->alert_event_ids);
    }

    public function test_failed_channel_logs_failure_and_does_not_crash(): void
    {
        NotificationPolicy::create(['name' => 'any', 'priority' => 1, 'channels' => ['email']]);
        // Deliberately NOT configuring SMTP — sendEmail's guard throws before any network attempt.
        $this->serverWithCpu(95);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'warning']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate')->assertExitCode(0); // must not crash

        $delivery = NotificationDelivery::first();
        $this->assertSame('failed', $delivery->status);
        $this->assertNotEmpty($delivery->error);
    }

    public function test_repeat_interval_renotifies_a_still_firing_alert(): void
    {
        $this->configureEmailSettings();
        NotificationPolicy::create(['name' => 'any', 'priority' => 1, 'channels' => ['email']]);

        $this->serverWithCpu(95);
        AlertRule::create([
            'name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90,
            'for_duration_seconds' => 0, 'severity' => 'warning', 'notification_repeat_interval_seconds' => 600,
        ]);

        $this->artisan('alerts:evaluate'); // -> pending
        $this->artisan('alerts:evaluate'); // -> firing, notified once (delivery #1)

        Carbon::setTestNow(now()->addSeconds(601));
        $this->artisan('alerts:evaluate'); // still firing, repeat interval elapsed -> notified again (delivery #2)

        $this->assertSame(2, NotificationDelivery::count());
    }

    public function test_no_repeat_interval_configured_notifies_only_once(): void
    {
        $this->configureEmailSettings();
        NotificationPolicy::create(['name' => 'any', 'priority' => 1, 'channels' => ['email']]);

        $this->serverWithCpu(95);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0, 'severity' => 'warning']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate'); // -> firing, notified

        Carbon::setTestNow(now()->addHours(2));
        $this->artisan('alerts:evaluate'); // still firing, no repeat configured -> not notified again

        $this->assertSame(1, NotificationDelivery::count());
    }

    public function test_notification_routes_require_permission(): void
    {
        $noPerm = User::factory()->create();
        $this->actingAs($noPerm)->getJson('/api/notification-policies')->assertForbidden();
        $this->actingAs($noPerm)->getJson('/api/notification-deliveries')->assertForbidden();
    }

    public function test_admin_can_manage_notification_policies_and_it_is_audited(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $create = $this->actingAs($admin)->postJson('/api/notification-policies', [
            'name' => 'test policy', 'priority' => 5, 'channels' => ['telegram'],
        ]);
        $create->assertCreated();
        $this->assertTrue(AuditLog::where('action', 'notification_policy.created')->exists());

        $this->actingAs($admin)->getJson('/api/notification-policies')->assertOk()->assertJsonCount(1);
    }
}

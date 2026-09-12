<?php

namespace Tests\Feature\Alerts;

use App\Models\AlertEvent;
use App\Models\AlertRule;
use App\Models\AlertSilence;
use App\Models\AlertState;
use App\Models\AuditLog;
use App\Models\MaintenanceWindow;
use App\Models\Server;
use App\Models\ServerMetric;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AlertEvaluationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
        Carbon::setTestNow(now());
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    private function serverWithCpu(float $usagePercent): Server
    {
        $server = Server::create(['name' => 'eval-target']);
        ServerMetric::create(['server_id' => $server->id, 'cpu' => ['usage_percent' => $usagePercent], 'collected_at' => now()]);

        return $server;
    }

    public function test_breaching_metric_starts_pending_not_immediately_firing(): void
    {
        $server = $this->serverWithCpu(95);
        AlertRule::create([
            'name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90,
            'for_duration_seconds' => 300,
        ]);

        $this->artisan('alerts:evaluate')->assertExitCode(0);

        $state = AlertState::first();
        $this->assertSame('pending', $state->state);
        $this->assertNull($state->fired_at);
    }

    public function test_pending_transitions_to_firing_after_for_duration_elapses(): void
    {
        $server = $this->serverWithCpu(95);
        AlertRule::create([
            'name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90,
            'for_duration_seconds' => 300,
        ]);

        $this->artisan('alerts:evaluate'); // -> pending
        Carbon::setTestNow(now()->addSeconds(301));
        $this->artisan('alerts:evaluate'); // -> firing

        $state = AlertState::first();
        $this->assertSame('firing', $state->state);
        $this->assertNotNull($state->fired_at);
        $this->assertSame(1, AlertEvent::where('to_state', 'firing')->count());
    }

    public function test_repeated_firing_evaluations_do_not_create_duplicate_events(): void
    {
        $this->serverWithCpu(95);
        AlertRule::create([
            'name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90,
            'for_duration_seconds' => 0,
        ]);

        $this->artisan('alerts:evaluate'); // pending -> immediately firing (duration 0)
        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        $this->assertSame(1, AlertEvent::where('to_state', 'firing')->count());
        $this->assertSame('firing', AlertState::first()->state);
    }

    public function test_clearing_the_breach_resolves_the_alert(): void
    {
        $server = $this->serverWithCpu(95);
        $rule = AlertRule::create([
            'name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90,
            'for_duration_seconds' => 0,
        ]);

        $this->artisan('alerts:evaluate'); // -> firing

        ServerMetric::where('server_id', $server->id)->update(['cpu' => ['usage_percent' => 5]]);
        $this->artisan('alerts:evaluate'); // -> resolved

        $state = AlertState::first();
        $this->assertSame('resolved', $state->state);
        $this->assertSame(1, AlertEvent::where('to_state', 'resolved')->count());
    }

    public function test_server_with_no_metric_is_skipped_for_threshold_rules(): void
    {
        Server::create(['name' => 'no-metric-yet']);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90]);

        $this->artisan('alerts:evaluate')->assertExitCode(0);

        $this->assertSame(0, AlertState::count());
    }

    public function test_server_offline_rule_fires_from_heartbeat_alone_without_any_metric(): void
    {
        $server = Server::create(['name' => 'never-connected']); // last_heartbeat_at null -> status 'unknown', not 'offline'
        AlertRule::create(['name' => 'offline', 'metric' => 'server_offline', 'for_duration_seconds' => 0]);

        $this->artisan('alerts:evaluate');
        $this->assertSame('normal', AlertState::first()->state); // 'unknown' status never breaches server_offline

        $server->update(['last_heartbeat_at' => now()->subMinutes(10)]); // now genuinely 'offline'
        $this->artisan('alerts:evaluate'); // -> pending
        $this->artisan('alerts:evaluate'); // -> firing (0s duration, elapsed >= 0 on the next tick)

        $this->assertSame('firing', AlertState::first()->state);
    }

    public function test_silence_flags_is_silenced_without_changing_real_state(): void
    {
        $server = $this->serverWithCpu(95);
        $rule = AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0]);
        $this->artisan('alerts:evaluate'); // -> pending
        $this->artisan('alerts:evaluate'); // -> firing

        AlertSilence::create([
            'alert_rule_id' => $rule->id, 'server_id' => $server->id, 'reason' => 'known issue',
            'starts_at' => now()->subMinute(), 'ends_at' => now()->addHour(),
        ]);

        $state = AlertState::first();
        $this->assertSame('firing', $state->state);
        $this->assertTrue($state->isSilenced());
    }

    public function test_maintenance_window_scoped_to_server_flags_is_silenced(): void
    {
        $server = $this->serverWithCpu(95);
        AlertRule::create(['name' => 'high cpu', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'for_duration_seconds' => 0]);
        $this->artisan('alerts:evaluate');

        MaintenanceWindow::create([
            'name' => 'planned work', 'server_ids' => [$server->id],
            'starts_at' => now()->subMinute(), 'ends_at' => now()->addHour(),
        ]);

        $this->assertTrue(AlertState::first()->isSilenced());
    }

    public function test_alerts_route_requires_permission(): void
    {
        $noPerm = User::factory()->create();
        $this->actingAs($noPerm)->getJson('/api/alerts')->assertForbidden();
    }

    public function test_admin_can_create_and_list_alert_rules_and_it_is_audited(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->postJson('/api/alert-rules', [
            'name' => 'disk full', 'metric' => 'disk_percent', 'condition' => '>', 'threshold' => 85,
        ]);
        $response->assertCreated();

        $this->assertTrue(AuditLog::where('action', 'alert_rule.created')->exists());
        $this->actingAs($admin)->getJson('/api/alert-rules')->assertOk()->assertJsonCount(1);
    }
}

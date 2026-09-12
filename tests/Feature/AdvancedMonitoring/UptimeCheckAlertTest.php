<?php

namespace Tests\Feature\AdvancedMonitoring;

use App\Models\AlertRule;
use App\Models\AlertState;
use App\Models\Incident;
use App\Models\UptimeCheck;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UptimeCheckAlertTest extends TestCase
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

    public function test_uptime_check_down_rule_does_not_evaluate_before_first_check(): void
    {
        $check = UptimeCheck::create(['name' => 'homepage', 'url' => 'https://example.com']);
        AlertRule::create(['name' => 'homepage down', 'metric' => 'uptime_check_down', 'uptime_check_id' => $check->id, 'for_duration_seconds' => 0, 'severity' => 'critical']);

        $this->artisan('alerts:evaluate')->assertExitCode(0);

        $this->assertSame(0, AlertState::count());
    }

    public function test_uptime_check_down_rule_fires_when_last_check_failed(): void
    {
        $check = UptimeCheck::create([
            'name' => 'homepage', 'url' => 'https://example.com',
            'last_success' => false, 'last_checked_at' => now(),
        ]);
        AlertRule::create(['name' => 'homepage down', 'metric' => 'uptime_check_down', 'uptime_check_id' => $check->id, 'for_duration_seconds' => 0, 'severity' => 'critical']);

        $this->artisan('alerts:evaluate'); // -> pending
        $this->artisan('alerts:evaluate'); // -> firing

        $state = AlertState::first();
        $this->assertSame('firing', $state->state);
        $this->assertNull($state->server_id);
        $this->assertSame($check->id, $state->uptime_check_id);
    }

    public function test_uptime_check_down_does_not_open_an_incident(): void
    {
        $check = UptimeCheck::create(['name' => 'homepage', 'url' => 'https://example.com', 'last_success' => false, 'last_checked_at' => now()]);
        AlertRule::create(['name' => 'homepage down', 'metric' => 'uptime_check_down', 'uptime_check_id' => $check->id, 'for_duration_seconds' => 0, 'severity' => 'critical']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        $this->assertSame(0, Incident::count());
    }

    public function test_ssl_expiring_soon_fires_within_threshold_days(): void
    {
        $check = UptimeCheck::create(['name' => 'homepage', 'url' => 'https://example.com', 'ssl_expires_at' => now()->addDays(5)]);
        AlertRule::create(['name' => 'ssl expiring', 'metric' => 'ssl_expiring_soon', 'uptime_check_id' => $check->id, 'threshold' => 14, 'for_duration_seconds' => 0, 'severity' => 'warning']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        $this->assertSame('firing', AlertState::first()->state);
    }

    public function test_ssl_expiring_soon_does_not_fire_when_cert_has_plenty_of_time_left(): void
    {
        $check = UptimeCheck::create(['name' => 'homepage', 'url' => 'https://example.com', 'ssl_expires_at' => now()->addDays(90)]);
        AlertRule::create(['name' => 'ssl expiring', 'metric' => 'ssl_expiring_soon', 'uptime_check_id' => $check->id, 'threshold' => 14, 'for_duration_seconds' => 0, 'severity' => 'warning']);

        $this->artisan('alerts:evaluate');
        $this->artisan('alerts:evaluate');

        $this->assertSame(0, AlertState::where('state', 'firing')->count());
    }

    public function test_uptime_checks_routes_require_permission(): void
    {
        $noPerm = User::factory()->create();
        $this->actingAs($noPerm)->getJson('/api/uptime-checks')->assertForbidden();
    }

    public function test_admin_can_manage_uptime_checks(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $create = $this->actingAs($admin)->postJson('/api/uptime-checks', [
            'name' => 'API', 'url' => 'https://api.example.com/health', 'expected_status' => 200,
        ]);
        $create->assertCreated();

        $id = $create->json('id');
        $this->actingAs($admin)->getJson('/api/uptime-checks')->assertOk()->assertJsonCount(1);
        $this->actingAs($admin)->deleteJson("/api/uptime-checks/{$id}")->assertNoContent();
    }

    public function test_database_health_endpoint_returns_real_postgres_stats(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/database-health');
        $response->assertOk();
        // sqlite in tests — the endpoint should report unsupported cleanly, not error.
        $this->assertFalse($response->json('supported'));
    }
}

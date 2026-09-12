<?php

namespace Tests\Feature\Analytics;

use App\Models\AlertEvent;
use App\Models\AlertRule;
use App\Models\Incident;
use App\Models\Server;
use App\Models\ServerMetric;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopNTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_top_n_route_requires_servers_view_permission(): void
    {
        $noPerm = User::factory()->create();
        $this->actingAs($noPerm)->getJson('/api/monitoring/overview/top')->assertForbidden();
    }

    public function test_top_cpu_ranks_servers_by_current_cpu_usage(): void
    {
        $hot = Server::create(['name' => 'hot']);
        ServerMetric::create(['server_id' => $hot->id, 'cpu' => ['usage_percent' => 95], 'collected_at' => now()]);
        $cool = Server::create(['name' => 'cool']);
        ServerMetric::create(['server_id' => $cool->id, 'cpu' => ['usage_percent' => 10], 'collected_at' => now()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/monitoring/overview/top');
        $response->assertOk();
        $this->assertSame('hot', $response->json('top_cpu.0.server_name'));
    }

    public function test_most_alerts_ranks_by_firing_alert_event_count(): void
    {
        $noisy = Server::create(['name' => 'noisy']);
        $rule = AlertRule::create(['name' => 'cpu high', 'metric' => 'cpu_percent', 'condition' => '>', 'threshold' => 90, 'severity' => 'critical']);
        AlertEvent::create(['alert_rule_id' => $rule->id, 'server_id' => $noisy->id, 'from_state' => 'pending', 'to_state' => 'firing', 'occurred_at' => now()]);
        AlertEvent::create(['alert_rule_id' => $rule->id, 'server_id' => $noisy->id, 'from_state' => 'resolved', 'to_state' => 'firing', 'occurred_at' => now()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/monitoring/overview/top');
        $this->assertSame('noisy', $response->json('most_alerts.0.server_name'));
        $this->assertSame(2, $response->json('most_alerts.0.value'));
    }

    public function test_most_downtime_sums_incident_duration_per_server(): void
    {
        $server = Server::create(['name' => 'flaky']);
        Incident::create(['title' => 'x', 'severity' => 'critical', 'server_id' => $server->id, 'status' => 'resolved', 'started_at' => now()->subHours(2), 'resolved_at' => now()->subHour()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/monitoring/overview/top');
        $this->assertSame('flaky', $response->json('most_downtime.0.server_name'));
        $this->assertSame(3600, $response->json('most_downtime.0.value'));
    }
}

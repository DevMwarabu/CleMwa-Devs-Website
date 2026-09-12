<?php

namespace Tests\Feature\Analytics;

use App\Models\AlertRule;
use App\Models\AlertState;
use App\Models\Server;
use App\Models\ServerMetric;
use App\Models\User;
use App\Support\HealthScoreCalculator;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthScoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_healthy_server_scores_100_with_no_reasons(): void
    {
        $server = Server::create(['name' => 'healthy', 'last_heartbeat_at' => now()]);
        ServerMetric::create(['server_id' => $server->id, 'cpu' => ['usage_percent' => 20], 'memory' => ['total_mb' => 1000, 'used_mb' => 300], 'collected_at' => now()]);

        $result = HealthScoreCalculator::calculate($server->fresh());
        $this->assertSame(100, $result['score']);
        $this->assertEmpty($result['reasons']);
    }

    public function test_offline_server_is_penalized(): void
    {
        $server = Server::create(['name' => 'offline-01', 'last_heartbeat_at' => now()->subMinutes(10)]);

        $result = HealthScoreCalculator::calculate($server->fresh());
        $this->assertLessThan(100, $result['score']);
        $this->assertStringContainsString('offline', $result['reasons'][0]);
    }

    public function test_unknown_server_with_no_heartbeat_is_penalized(): void
    {
        $server = Server::create(['name' => 'unknown-01']);

        $result = HealthScoreCalculator::calculate($server->fresh());
        $this->assertLessThan(100, $result['score']);
    }

    public function test_high_cpu_usage_reduces_score_and_adds_a_reason(): void
    {
        $server = Server::create(['name' => 'hot-cpu', 'last_heartbeat_at' => now()]);
        ServerMetric::create(['server_id' => $server->id, 'cpu' => ['usage_percent' => 95], 'collected_at' => now()]);

        $result = HealthScoreCalculator::calculate($server->fresh());
        $this->assertSame(80, $result['score']);
        $this->assertStringContainsString('CPU', $result['reasons'][0]);
    }

    public function test_firing_critical_alert_reduces_score(): void
    {
        $server = Server::create(['name' => 'alerting', 'last_heartbeat_at' => now()]);
        $rule = AlertRule::create(['name' => 'cpu high', 'metric' => 'cpu_percent', 'server_id' => $server->id, 'condition' => '>', 'threshold' => 90, 'severity' => 'critical']);
        AlertState::create(['alert_rule_id' => $rule->id, 'server_id' => $server->id, 'state' => 'firing']);

        $result = HealthScoreCalculator::calculate($server->fresh());
        $this->assertSame(75, $result['score']);
        $this->assertStringContainsString('critical', $result['reasons'][0]);
    }

    public function test_score_never_drops_below_zero(): void
    {
        $server = Server::create(['name' => 'disaster', 'last_heartbeat_at' => now()->subMinutes(10)]);
        ServerMetric::create(['server_id' => $server->id, 'cpu' => ['usage_percent' => 99], 'memory' => ['total_mb' => 1000, 'used_mb' => 999], 'disk' => ['filesystems' => [['mount' => '/', 'usage_percent' => 99]]], 'collected_at' => now()]);
        for ($i = 0; $i < 10; $i++) {
            $rule = AlertRule::create(['name' => "rule-{$i}", 'metric' => 'cpu_percent', 'server_id' => $server->id, 'condition' => '>', 'threshold' => 90, 'severity' => 'critical']);
            AlertState::create(['alert_rule_id' => $rule->id, 'server_id' => $server->id, 'state' => 'firing']);
        }

        $result = HealthScoreCalculator::calculate($server->fresh());
        $this->assertSame(0, $result['score']);
    }

    public function test_server_index_route_exposes_health_score(): void
    {
        $this->seed(RolePermissionSeeder::class);
        Server::create(['name' => 'exposed', 'last_heartbeat_at' => now()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/servers');
        $response->assertOk();
        $this->assertArrayHasKey('health_score', $response->json()[0]);
    }
}

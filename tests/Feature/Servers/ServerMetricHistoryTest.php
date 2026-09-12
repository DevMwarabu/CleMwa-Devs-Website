<?php

namespace Tests\Feature\Servers;

use App\Models\ServerMetricHistory;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ServerMetricHistoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    private function registerServer(): array
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $create = $this->actingAs($admin)->postJson('/api/servers', ['name' => 'history-01']);

        return [$create->json('server.id'), $create->json('token'), $admin];
    }

    private function withAgentToken(string $token): self
    {
        Auth::forgetGuards();

        return $this->withHeader('Authorization', "Bearer {$token}");
    }

    public function test_each_metrics_push_appends_a_history_row_instead_of_overwriting(): void
    {
        [$serverId, $token] = $this->registerServer();

        $this->withAgentToken($token)->postJson('/api/agent/metrics', ['cpu' => ['usage_percent' => 10]])->assertOk();
        $this->withAgentToken($token)->postJson('/api/agent/metrics', ['cpu' => ['usage_percent' => 20]])->assertOk();
        $this->withAgentToken($token)->postJson('/api/agent/metrics', ['cpu' => ['usage_percent' => 30]])->assertOk();

        $this->assertSame(3, ServerMetricHistory::where('server_id', $serverId)->count());
    }

    public function test_history_endpoint_returns_raw_points_for_short_range(): void
    {
        [$serverId, $token, $admin] = $this->registerServer();

        $this->withAgentToken($token)->postJson('/api/agent/metrics', [
            'cpu' => ['usage_percent' => 15],
            'memory' => ['total_mb' => 1000, 'used_mb' => 500],
            'disk' => ['filesystems' => [['mount' => '/', 'usage_percent' => 42]]],
        ])->assertOk();

        $response = $this->actingAs($admin)->getJson("/api/servers/{$serverId}/metrics/history?range=1h");

        $response->assertOk();
        $response->assertJsonPath('range', '1h');
        $points = $response->json('points');
        $this->assertCount(1, $points);
        $this->assertSame(15, $points[0]['cpu_percent']);
        $this->assertEquals(50, $points[0]['memory_percent']);
        $this->assertSame(42, $points[0]['disk_percent']);
    }

    public function test_history_endpoint_returns_bucketed_points_for_long_range(): void
    {
        [$serverId, , $admin] = $this->registerServer();

        ServerMetricHistory::create(['server_id' => $serverId, 'cpu' => ['usage_percent' => 10], 'collected_at' => now()->subHours(2)]);
        ServerMetricHistory::create(['server_id' => $serverId, 'cpu' => ['usage_percent' => 20], 'collected_at' => now()->subHours(2)->addMinutes(10)]);
        ServerMetricHistory::create(['server_id' => $serverId, 'cpu' => ['usage_percent' => 30], 'collected_at' => now()->subHour()]);

        $response = $this->actingAs($admin)->getJson("/api/servers/{$serverId}/metrics/history?range=24h");

        $response->assertOk();
        $response->assertJsonPath('range', '24h');
        $points = $response->json('points');
        // Two distinct hour-buckets: the first keeps its LAST observed value (20), the second its only value (30).
        $this->assertCount(2, $points);
        $this->assertEquals(20, $points[0]['cpu_percent']);
        $this->assertEquals(30, $points[1]['cpu_percent']);
    }

    public function test_history_endpoint_defaults_to_1h_for_invalid_range(): void
    {
        [$serverId, , $admin] = $this->registerServer();

        $response = $this->actingAs($admin)->getJson("/api/servers/{$serverId}/metrics/history?range=bogus");
        $response->assertOk();
        $response->assertJsonPath('range', '1h');
    }

    public function test_history_endpoint_requires_servers_view_permission(): void
    {
        [$serverId] = $this->registerServer();

        $noPerm = User::factory()->create(); // no role assigned at all

        $this->actingAs($noPerm)->getJson("/api/servers/{$serverId}/metrics/history")->assertForbidden();
    }

    public function test_old_history_rows_are_deleted_by_prune_command_and_recent_ones_kept(): void
    {
        [$serverId] = $this->registerServer();

        ServerMetricHistory::create(['server_id' => $serverId, 'cpu' => ['usage_percent' => 1], 'collected_at' => now()->subDays(40)]);
        ServerMetricHistory::create(['server_id' => $serverId, 'cpu' => ['usage_percent' => 2], 'collected_at' => now()->subDays(1)]);

        $this->artisan('metrics:prune')->assertExitCode(0);

        $this->assertSame(1, ServerMetricHistory::where('server_id', $serverId)->count());
        $this->assertSame(2, ServerMetricHistory::where('server_id', $serverId)->first()->cpu['usage_percent']);
    }
}

<?php

namespace Tests\Feature\Monitoring;

use App\Models\Server;
use App\Models\ServerMetricHistory;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MonitoringOverviewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        return $user;
    }

    private function withAgentToken(string $token): self
    {
        Auth::forgetGuards();

        return $this->withHeader('Authorization', "Bearer {$token}");
    }

    public function test_summary_counts_servers_by_status_and_excludes_no_metric_servers_from_averages(): void
    {
        $admin = $this->admin();

        // Server A: reporting, online, real metrics.
        $createA = $this->actingAs($admin)->postJson('/api/servers', ['name' => 'fleet-a']);
        $tokenA = $createA->json('token');
        $this->withAgentToken($tokenA)->postJson('/api/agent/metrics', [
            'cpu' => ['usage_percent' => 40],
            'memory' => ['total_mb' => 1000, 'used_mb' => 500],
            'disk' => ['filesystems' => [['mount' => '/', 'usage_percent' => 20]]],
        ])->assertOk();

        // Server B: registered, never reported — must not drag averages toward 0.
        $this->actingAs($admin)->postJson('/api/servers', ['name' => 'fleet-b'])->assertCreated();

        $response = $this->actingAs($admin)->getJson('/api/monitoring/overview');
        $response->assertOk();

        $this->assertSame(2, $response->json('total_servers'));
        $this->assertSame(1, $response->json('online'));
        $this->assertSame(1, $response->json('unknown'));
        $this->assertSame(1, $response->json('reporting_servers'));
        $this->assertEquals(40, $response->json('avg_cpu_percent'));
        $this->assertEquals(50, $response->json('avg_memory_percent'));
        $this->assertEquals(20, $response->json('avg_disk_percent'));
    }

    public function test_summary_requires_servers_view_permission(): void
    {
        $noPerm = User::factory()->create();

        $this->actingAs($noPerm)->getJson('/api/monitoring/overview')->assertForbidden();
    }

    public function test_history_averages_across_servers_per_bucket(): void
    {
        $admin = $this->admin();
        $serverA = Server::create(['name' => 'a']);
        $serverB = Server::create(['name' => 'b']);

        $now = now();
        ServerMetricHistory::create(['server_id' => $serverA->id, 'cpu' => ['usage_percent' => 20], 'collected_at' => $now]);
        ServerMetricHistory::create(['server_id' => $serverB->id, 'cpu' => ['usage_percent' => 40], 'collected_at' => $now]);

        $response = $this->actingAs($admin)->getJson('/api/monitoring/overview/history?range=1h');
        $response->assertOk();

        $points = $response->json('points');
        $this->assertNotEmpty($points);
        $this->assertEquals(30, $points[0]['cpu_percent']);
    }
}

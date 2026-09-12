<?php

namespace Tests\Feature\Servers;

use App\Models\ServerMetric;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ServerMetricsTest extends TestCase
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

        $create = $this->actingAs($admin)->postJson('/api/servers', ['name' => 'metrics-01']);

        return [$create->json('server.id'), $create->json('token'), $admin];
    }

    /** @see ServerManagementTest::withAgentToken() for why forgetGuards() is needed here */
    private function withAgentToken(string $token): self
    {
        Auth::forgetGuards();

        return $this->withHeader('Authorization', "Bearer {$token}");
    }

    public function test_metrics_push_persists_a_realistic_payload(): void
    {
        [$serverId, $token] = $this->registerServer();

        $payload = [
            'agent_version' => '0.1.0',
            'cpu' => ['usage_percent' => 42.5, 'load' => ['1m' => 0.8, '5m' => 0.6, '15m' => 0.5]],
            'memory' => ['total_mb' => 8192, 'used_mb' => 4096, 'available_mb' => 4096],
            'disk' => [['filesystem' => '/dev/sda1', 'mount' => '/', 'size_gb' => 50, 'used_gb' => 20]],
            'network' => [['interface' => 'eth0', 'state' => 'up', 'rx_bytes' => 1000, 'tx_bytes' => 2000]],
            'processes' => ['total' => 120, 'zombie' => 0, 'top_cpu' => [['pid' => 1, 'name' => 'init', 'cpu_percent' => 0.1]]],
            'services' => [['name' => 'nginx', 'active' => true, 'enabled' => true]],
        ];

        $response = $this->withAgentToken($token)->postJson('/api/agent/metrics', $payload);
        $response->assertOk();

        $metric = ServerMetric::where('server_id', $serverId)->first();
        $this->assertNotNull($metric);
        $this->assertSame(42.5, $metric->cpu['usage_percent']);
        $this->assertSame(120, $metric->processes['total']);
        $this->assertNotNull($metric->collected_at);
    }

    public function test_partial_payload_still_succeeds(): void
    {
        [, $token] = $this->registerServer();

        $response = $this->withAgentToken($token)->postJson('/api/agent/metrics', [
            'cpu' => ['usage_percent' => 10],
        ]);

        $response->assertOk();
    }

    public function test_metrics_push_updates_status_to_online(): void
    {
        [$serverId, $token, $admin] = $this->registerServer();

        $this->withAgentToken($token)->postJson('/api/agent/metrics', ['cpu' => ['usage_percent' => 5]])->assertOk();

        $show = $this->actingAs($admin)->getJson("/api/servers/{$serverId}");
        $show->assertOk();
        $this->assertSame('online', $show->json('status'));
        $this->assertNotNull($show->json('metric.cpu.usage_percent'));
    }

    public function test_metrics_are_overwritten_not_appended(): void
    {
        [$serverId, $token] = $this->registerServer();

        $this->withAgentToken($token)->postJson('/api/agent/metrics', ['cpu' => ['usage_percent' => 10]])->assertOk();
        $this->withAgentToken($token)->postJson('/api/agent/metrics', ['cpu' => ['usage_percent' => 90]])->assertOk();

        $this->assertSame(1, ServerMetric::where('server_id', $serverId)->count());
        $this->assertSame(90, ServerMetric::where('server_id', $serverId)->first()->cpu['usage_percent']);
    }
}

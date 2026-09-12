<?php

namespace Tests\Feature\Logs;

use App\Models\ServerLog;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\Servers\ServerManagementTest;
use Tests\TestCase;

class ServerLogIngestionTest extends TestCase
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

        $create = $this->actingAs($admin)->postJson('/api/servers', ['name' => 'logs-01']);

        return [$create->json('server.id'), $create->json('token'), $admin];
    }

    /** @see ServerManagementTest::withAgentToken() for why forgetGuards() is needed here */
    private function withAgentToken(string $token): self
    {
        Auth::forgetGuards();

        return $this->withHeader('Authorization', "Bearer {$token}");
    }

    public function test_metrics_push_with_logs_creates_server_log_rows(): void
    {
        [$serverId, $token] = $this->registerServer();

        $response = $this->withAgentToken($token)->postJson('/api/agent/metrics', [
            'logs' => [
                ['source' => '/var/log/nginx/error.log', 'message' => '2026/09/12 10:00:00 [error] connect() failed'],
                ['source' => 'journalctl:nginx', 'message' => 'Started nginx service.'],
            ],
        ]);

        $response->assertOk();
        $this->assertSame(2, ServerLog::where('server_id', $serverId)->count());
    }

    public function test_log_level_is_heuristically_parsed_from_message(): void
    {
        [$serverId, $token] = $this->registerServer();

        $this->withAgentToken($token)->postJson('/api/agent/metrics', [
            'logs' => [
                ['source' => '/var/log/app.log', 'message' => 'CRITICAL: database connection lost'],
            ],
        ])->assertOk();

        $log = ServerLog::where('server_id', $serverId)->first();
        $this->assertSame('CRITICAL', $log->level);
    }

    public function test_message_with_no_recognizable_level_defaults_to_info(): void
    {
        [$serverId, $token] = $this->registerServer();

        $this->withAgentToken($token)->postJson('/api/agent/metrics', [
            'logs' => [
                ['source' => '/var/log/app.log', 'message' => 'user logged in'],
            ],
        ])->assertOk();

        $this->assertSame('INFO', ServerLog::where('server_id', $serverId)->first()->level);
    }

    public function test_metrics_push_without_logs_key_still_succeeds(): void
    {
        [, $token] = $this->registerServer();

        $this->withAgentToken($token)->postJson('/api/agent/metrics', ['cpu' => ['usage_percent' => 5]])
            ->assertOk();

        $this->assertSame(0, ServerLog::count());
    }
}

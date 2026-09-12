<?php

namespace Tests\Feature\Servers;

use App\Models\AuditLog;
use App\Models\Server;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ServerManagementTest extends TestCase
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

    private function operator(): User
    {
        $user = User::factory()->create();
        $user->assignRole('Operator');

        return $user;
    }

    /**
     * Once a real request has run auth:sanctum, Auth::guard('sanctum') is a
     * RequestGuard cached by AuthManager for the rest of the test, and it
     * memoizes whatever principal it first resolved (e.g. the admin from an
     * earlier actingAs()->postJson() call) regardless of the bearer token on
     * a later request. forgetGuards() drops that cache so the next request
     * re-resolves the guard from the actual Authorization header — this is
     * a test-isolation artifact only; a real stateless agent request never
     * shares a guard instance with an admin's request.
     */
    private function withAgentToken(string $token): self
    {
        Auth::forgetGuards();

        return $this->withHeader('Authorization', "Bearer {$token}");
    }

    public function test_operator_can_list_but_not_create_servers(): void
    {
        $operator = $this->operator();

        $this->actingAs($operator)->getJson('/api/servers')->assertOk();
        $this->actingAs($operator)->postJson('/api/servers', ['name' => 'api-01'])->assertForbidden();
    }

    public function test_admin_can_create_server_and_receives_token_once(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->postJson('/api/servers', [
            'name' => 'api-01',
            'environment' => 'production',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure(['server' => ['id', 'name', 'status'], 'token']);
        $this->assertNotEmpty($response->json('token'));

        $serverId = $response->json('server.id');

        $show = $this->actingAs($admin)->getJson("/api/servers/{$serverId}");
        $show->assertOk();
        $show->assertJsonMissing(['token']);
        $this->assertArrayNotHasKey('token', $show->json());
    }

    public function test_server_created_writes_audit_log(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->postJson('/api/servers', ['name' => 'api-01'])->assertCreated();

        $this->assertTrue(AuditLog::where('action', 'server.created')->exists());
    }

    public function test_new_server_status_is_unknown_until_first_heartbeat(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->postJson('/api/servers', ['name' => 'api-01']);
        $this->assertSame('unknown', $response->json('server.status'));
    }

    public function test_agent_heartbeat_updates_status_to_online(): void
    {
        $admin = $this->admin();
        $create = $this->actingAs($admin)->postJson('/api/servers', ['name' => 'api-01']);
        $token = $create->json('token');
        $serverId = $create->json('server.id');

        $response = $this->withAgentToken($token)
            ->postJson('/api/agent/heartbeat', ['agent_version' => '0.1.0']);

        $response->assertOk();
        $this->assertSame('online', $response->json('status'));

        $server = Server::find($serverId);
        $this->assertNotNull($server->last_heartbeat_at);
        $this->assertSame('0.1.0', $server->agent_version);
    }

    public function test_rotate_token_invalidates_the_old_one(): void
    {
        $admin = $this->admin();
        $create = $this->actingAs($admin)->postJson('/api/servers', ['name' => 'api-01']);
        $oldToken = $create->json('token');
        $serverId = $create->json('server.id');

        $rotate = $this->actingAs($admin)->postJson("/api/servers/{$serverId}/rotate-token");
        $rotate->assertOk();
        $newToken = $rotate->json('token');

        $this->assertNotSame($oldToken, $newToken);

        $this->withAgentToken($oldToken)
            ->postJson('/api/agent/heartbeat')
            ->assertUnauthorized();

        $this->withAgentToken($newToken)
            ->postJson('/api/agent/heartbeat')
            ->assertOk();
    }

    public function test_agent_token_is_rejected_on_admin_routes(): void
    {
        $admin = $this->admin();
        $create = $this->actingAs($admin)->postJson('/api/servers', ['name' => 'api-01']);
        $token = $create->json('token');

        $this->withAgentToken($token)
            ->getJson('/api/leads')
            ->assertForbidden();
    }

    public function test_user_token_is_rejected_on_agent_routes(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->postJson('/api/agent/heartbeat')
            ->assertForbidden();
    }

    public function test_deleting_server_revokes_its_tokens(): void
    {
        $admin = $this->admin();
        $create = $this->actingAs($admin)->postJson('/api/servers', ['name' => 'api-01']);
        $token = $create->json('token');
        $serverId = $create->json('server.id');

        $this->actingAs($admin)->deleteJson("/api/servers/{$serverId}")->assertNoContent();

        $this->withAgentToken($token)
            ->postJson('/api/agent/heartbeat')
            ->assertUnauthorized();
    }
}

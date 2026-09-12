<?php

namespace Tests\Feature\Logs;

use App\Models\Server;
use App\Models\ServerLog;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServerLogApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    private function server(): Server
    {
        return Server::create(['name' => 'logs-api-01']);
    }

    public function test_logs_route_requires_logs_view_permission(): void
    {
        $server = $this->server();
        $noPerm = User::factory()->create();

        $this->actingAs($noPerm)->getJson("/api/servers/{$server->id}/logs")->assertForbidden();
    }

    public function test_export_route_requires_logs_export_permission(): void
    {
        $server = $this->server();
        $noPerm = User::factory()->create();

        $this->actingAs($noPerm)->getJson("/api/servers/{$server->id}/logs/export")->assertForbidden();
    }

    public function test_admin_can_list_logs_for_a_server(): void
    {
        $server = $this->server();
        ServerLog::create(['server_id' => $server->id, 'source' => 'a.log', 'level' => 'INFO', 'message' => 'hello world', 'logged_at' => now()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson("/api/servers/{$server->id}/logs");
        $response->assertOk();
        $this->assertSame(1, $response->json('total'));
    }

    public function test_search_filters_by_message_case_insensitively(): void
    {
        $server = $this->server();
        ServerLog::create(['server_id' => $server->id, 'source' => 'a.log', 'level' => 'ERROR', 'message' => 'Connection Refused', 'logged_at' => now()]);
        ServerLog::create(['server_id' => $server->id, 'source' => 'a.log', 'level' => 'INFO', 'message' => 'all good', 'logged_at' => now()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson("/api/servers/{$server->id}/logs?search=refused");
        $response->assertOk();
        $this->assertSame(1, $response->json('total'));
    }

    public function test_level_filter_narrows_results(): void
    {
        $server = $this->server();
        ServerLog::create(['server_id' => $server->id, 'source' => 'a.log', 'level' => 'ERROR', 'message' => 'one', 'logged_at' => now()]);
        ServerLog::create(['server_id' => $server->id, 'source' => 'a.log', 'level' => 'INFO', 'message' => 'two', 'logged_at' => now()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson("/api/servers/{$server->id}/logs?level=ERROR");
        $this->assertSame(1, $response->json('total'));
    }

    public function test_date_range_filter_excludes_logs_outside_range(): void
    {
        $server = $this->server();
        ServerLog::create(['server_id' => $server->id, 'source' => 'a.log', 'level' => 'INFO', 'message' => 'old', 'logged_at' => now()->subDays(10)]);
        ServerLog::create(['server_id' => $server->id, 'source' => 'a.log', 'level' => 'INFO', 'message' => 'recent', 'logged_at' => now()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson("/api/servers/{$server->id}/logs?date_from=".now()->subDay()->toDateString());
        $this->assertSame(1, $response->json('total'));
    }

    public function test_export_streams_a_csv_with_matching_rows(): void
    {
        $server = $this->server();
        ServerLog::create(['server_id' => $server->id, 'source' => 'a.log', 'level' => 'INFO', 'message' => 'hello', 'logged_at' => now()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get("/api/servers/{$server->id}/logs/export");
        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        $content = $response->streamedContent();
        $this->assertStringContainsString('logged_at,source,level,message', $content);
        $this->assertStringContainsString('hello', $content);
    }

    public function test_logs_are_scoped_to_their_own_server(): void
    {
        $serverA = $this->server();
        $serverB = Server::create(['name' => 'logs-api-02']);
        ServerLog::create(['server_id' => $serverA->id, 'source' => 'a.log', 'level' => 'INFO', 'message' => 'from a', 'logged_at' => now()]);
        ServerLog::create(['server_id' => $serverB->id, 'source' => 'b.log', 'level' => 'INFO', 'message' => 'from b', 'logged_at' => now()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson("/api/servers/{$serverA->id}/logs");
        $this->assertSame(1, $response->json('total'));
        $this->assertSame('from a', $response->json('data.0.message'));
    }
}

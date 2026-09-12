<?php

namespace Tests\Feature\Analytics;

use App\Models\Server;
use App\Models\ServerMetricHistory;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompareHistoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_compare_route_requires_servers_view_permission(): void
    {
        $noPerm = User::factory()->create();
        $this->actingAs($noPerm)->getJson('/api/servers/compare/history')->assertForbidden();
    }

    public function test_compare_returns_a_series_per_requested_server(): void
    {
        $a = Server::create(['name' => 'server-a']);
        $b = Server::create(['name' => 'server-b']);
        ServerMetricHistory::create(['server_id' => $a->id, 'cpu' => ['usage_percent' => 10], 'collected_at' => now()]);
        ServerMetricHistory::create(['server_id' => $b->id, 'cpu' => ['usage_percent' => 20], 'collected_at' => now()]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson("/api/servers/compare/history?server_ids={$a->id},{$b->id}");
        $response->assertOk();
        $this->assertCount(2, $response->json('series'));
        $this->assertSame('server-a', $response->json('series.0.server_name'));
        $this->assertSame('server-b', $response->json('series.1.server_name'));
    }

    public function test_compare_caps_at_four_servers(): void
    {
        $ids = collect(range(1, 6))->map(fn ($i) => Server::create(['name' => "server-{$i}"])->id);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/servers/compare/history?server_ids='.$ids->implode(','));
        $this->assertCount(4, $response->json('series'));
    }

    public function test_compare_ignores_unknown_server_ids(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/servers/compare/history?server_ids=00000000-0000-0000-0000-000000000000');
        $response->assertOk();
        $this->assertCount(0, $response->json('series'));
    }
}

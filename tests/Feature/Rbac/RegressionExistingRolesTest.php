<?php

namespace Tests\Feature\Rbac;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Proves the RBAC/Phase-1 changes do not regress existing admin/editor access.
 */
class RegressionExistingRolesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_existing_admin_user_can_still_login(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonPath('user.role', 'admin');
    }

    public function test_existing_editor_user_can_still_login(): void
    {
        $user = User::factory()->create();
        $user->assignRole('editor');

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonPath('user.role', 'editor');
    }

    public function test_admin_can_still_hit_every_pre_existing_crud_endpoint(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        foreach (['/api/leads', '/api/projects', '/api/services', '/api/posts', '/api/testimonials',
            '/api/products', '/api/team-members', '/api/office-locations', '/api/users',
            '/api/newsletter-subscribers', '/api/dashboard'] as $endpoint) {
            $this->actingAs($user)->getJson($endpoint)->assertOk();
        }
    }

    public function test_editor_can_still_hit_pre_existing_crud_endpoints(): void
    {
        $user = User::factory()->create();
        $user->assignRole('editor');

        foreach (['/api/leads', '/api/projects', '/api/services'] as $endpoint) {
            $this->actingAs($user)->getJson($endpoint)->assertOk();
        }
    }
}

<?php

namespace Tests\Feature\Rbac;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolePermissionSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_all_permissions_and_roles(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $this->assertSame(24, Permission::count());
        foreach (['Super Admin', 'Administrator', 'Monitoring Engineer', 'Operator', 'Viewer', 'admin', 'editor'] as $role) {
            $this->assertTrue(Role::where('name', $role)->exists(), "Role {$role} should exist");
        }
    }

    public function test_seeder_is_idempotent(): void
    {
        $this->seed(RolePermissionSeeder::class);
        $this->seed(RolePermissionSeeder::class);

        $this->assertSame(24, Permission::count());
        $this->assertSame(7, Role::count());
    }

    public function test_seeder_does_not_touch_existing_role_assignments(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $originalRoleId = $adminRole->id;
        $originalPivotCount = DB::table('model_has_roles')->count();

        $this->seed(RolePermissionSeeder::class);

        $adminRole->refresh();
        $this->assertSame($originalRoleId, $adminRole->id);
        $this->assertSame($originalPivotCount, DB::table('model_has_roles')->count());
        $this->assertTrue($user->fresh()->hasRole('admin'));
    }

    public function test_admin_role_gains_new_permissions_without_pivot_changes(): void
    {
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->seed(RolePermissionSeeder::class);

        $this->assertTrue($user->fresh()->can('settings.manage'));
        $this->assertTrue($user->fresh()->can('audit.view'));
    }

    public function test_editor_role_does_not_gain_settings_or_audit_permissions(): void
    {
        Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('editor');

        $this->seed(RolePermissionSeeder::class);

        $this->assertFalse($user->fresh()->can('settings.manage'));
        $this->assertFalse($user->fresh()->can('audit.view'));
        $this->assertTrue($user->fresh()->can('servers.view'));
    }
}

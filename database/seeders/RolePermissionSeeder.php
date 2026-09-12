<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    private const PERMISSIONS = [
        'servers.view', 'servers.create', 'servers.edit', 'servers.delete',
        'metrics.view',
        'dashboards.view', 'dashboards.create', 'dashboards.edit', 'dashboards.delete',
        'alerts.view', 'alerts.create', 'alerts.edit', 'alerts.delete', 'alerts.silence',
        'incidents.view', 'incidents.manage',
        'notifications.view', 'notifications.configure',
        'logs.view', 'logs.export',
        'reports.view', 'reports.generate',
        'settings.manage',
        'audit.view',
    ];

    private const VIEW_ONLY = [
        'servers.view', 'metrics.view', 'dashboards.view', 'alerts.view',
        'incidents.view', 'notifications.view', 'logs.view', 'reports.view',
    ];

    private const ROLE_MATRIX = [
        'Super Admin' => '*',
        'Administrator' => '*',
        'Monitoring Engineer' => [
            'servers.view', 'servers.create', 'servers.edit', 'servers.delete', 'metrics.view',
            'dashboards.view', 'dashboards.create', 'dashboards.edit', 'dashboards.delete',
            'alerts.view', 'alerts.create', 'alerts.edit', 'alerts.delete', 'alerts.silence',
            'incidents.view', 'incidents.manage', 'notifications.view',
            'logs.view', 'logs.export', 'reports.view', 'reports.generate',
        ],
        'Operator' => [
            'servers.view', 'metrics.view', 'dashboards.view', 'alerts.view', 'alerts.silence',
            'incidents.view', 'incidents.manage', 'notifications.view', 'logs.view', 'reports.view',
        ],
        'Viewer' => self::VIEW_ONLY,
        // Legacy roles already assigned to real users — additive grants only.
        'admin' => '*',
        'editor' => self::VIEW_ONLY,
    ];

    /**
     * Seed the roles and permissions. Idempotent and safe to rerun in production:
     * never touches model_has_roles, only creates/updates roles, permissions and
     * role_has_permissions rows.
     */
    public function run(): void
    {
        foreach (self::PERMISSIONS as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        $all = Permission::all();

        foreach (self::ROLE_MATRIX as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($perms === '*' ? $all : $perms);
        }
    }
}

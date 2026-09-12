<?php

namespace Tests\Feature\AuditLog;

use App\Models\AuditLog;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_role_change_creates_audit_log_entry_with_before_after(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $target = User::factory()->create();
        $target->assignRole('editor');

        $this->actingAs($admin)->putJson("/api/users/{$target->id}", [
            'role' => 'Operator',
        ])->assertOk();

        $log = AuditLog::where('action', 'user.role_changed')->first();

        $this->assertNotNull($log);
        $this->assertSame('editor', $log->before['role']);
        $this->assertSame('Operator', $log->after['role']);
        $this->assertSame($admin->id, $log->user_id);
    }

    public function test_settings_update_creates_audit_log_entry(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin)->putJson('/api/notification-settings', [
            'smtp_host' => 'smtp.example.com',
        ])->assertOk();

        $this->assertTrue(AuditLog::where('action', 'settings.updated')->exists());
    }

    public function test_audit_logs_cannot_be_updated_or_deleted(): void
    {
        $log = AuditLog::create([
            'action' => 'test.action',
            'resource' => 'Test',
        ]);

        $this->expectException(\RuntimeException::class);
        $log->update(['action' => 'changed']);
    }

    public function test_audit_log_delete_throws(): void
    {
        $log = AuditLog::create([
            'action' => 'test.action',
            'resource' => 'Test',
        ]);

        $this->expectException(\RuntimeException::class);
        $log->delete();
    }

    public function test_viewer_without_audit_permission_gets_403(): void
    {
        $user = User::factory()->create();
        $user->assignRole('editor');

        $this->actingAs($user)->getJson('/api/audit-logs')->assertForbidden();
    }

    public function test_admin_can_list_and_filter_audit_logs(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        AuditLog::create(['action' => 'auth.login', 'resource' => 'User', 'result' => 'success']);
        AuditLog::create(['action' => 'auth.login', 'resource' => 'User', 'result' => 'failure']);

        $response = $this->actingAs($admin)->getJson('/api/audit-logs?result=failure');

        $response->assertOk();
        $this->assertCount(1, $response->json('data'));
    }
}

<?php

namespace Tests\Feature\Alerts;

use App\Models\AuditLog;
use App\Models\Server;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlertSilenceAndMaintenanceTest extends TestCase
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

    public function test_operator_can_create_silence_but_not_maintenance_window(): void
    {
        $operator = User::factory()->create();
        $operator->assignRole('Operator');

        $this->actingAs($operator)->postJson('/api/alert-silences', [
            'reason' => 'known flapping', 'starts_at' => now(), 'ends_at' => now()->addHour(),
        ])->assertCreated();

        $this->actingAs($operator)->postJson('/api/maintenance-windows', [
            'name' => 'patch window', 'starts_at' => now(), 'ends_at' => now()->addHour(),
        ])->assertForbidden();
    }

    public function test_silence_creation_and_deletion_is_audited(): void
    {
        $admin = $this->admin();

        $create = $this->actingAs($admin)->postJson('/api/alert-silences', [
            'reason' => 'maintenance', 'starts_at' => now(), 'ends_at' => now()->addHour(),
        ]);
        $create->assertCreated();
        $this->assertTrue(AuditLog::where('action', 'alert_silence.created')->exists());

        $id = $create->json('id');
        $this->actingAs($admin)->deleteJson("/api/alert-silences/{$id}")->assertNoContent();
        $this->assertTrue(AuditLog::where('action', 'alert_silence.deleted')->exists());
    }

    public function test_admin_can_manage_maintenance_windows(): void
    {
        $admin = $this->admin();
        $server = Server::create(['name' => 'maint-target']);

        $create = $this->actingAs($admin)->postJson('/api/maintenance-windows', [
            'name' => 'patch window', 'server_ids' => [$server->id],
            'starts_at' => now(), 'ends_at' => now()->addHour(), 'reason' => 'patching',
        ]);
        $create->assertCreated();
        $this->assertTrue(AuditLog::where('action', 'maintenance_window.created')->exists());

        $id = $create->json('id');
        $this->actingAs($admin)->putJson("/api/maintenance-windows/{$id}", ['name' => 'patch window v2'])
            ->assertOk()
            ->assertJsonPath('name', 'patch window v2');

        $this->actingAs($admin)->deleteJson("/api/maintenance-windows/{$id}")->assertNoContent();
    }
}

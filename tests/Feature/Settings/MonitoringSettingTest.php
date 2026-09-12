<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonitoringSettingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_default_retention_is_thirty_days(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->getJson('/api/monitoring-settings');
        $response->assertOk();
        $response->assertJsonPath('raw_metrics_retention_days', 30);
    }

    public function test_admin_can_update_retention(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->putJson('/api/monitoring-settings', ['raw_metrics_retention_days' => 90]);
        $response->assertOk();
        $response->assertJsonPath('raw_metrics_retention_days', 90);
    }

    public function test_editor_cannot_view_or_update_monitoring_settings(): void
    {
        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $this->actingAs($editor)->getJson('/api/monitoring-settings')->assertForbidden();
        $this->actingAs($editor)->putJson('/api/monitoring-settings', ['raw_metrics_retention_days' => 10])->assertForbidden();
    }
}

<?php

namespace Tests\Feature\Settings;

use App\Models\NotificationSetting;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationSettingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_guest_cannot_view_notification_settings(): void
    {
        $this->getJson('/api/notification-settings')->assertUnauthorized();
    }

    public function test_editor_cannot_view_notification_settings(): void
    {
        $user = User::factory()->create();
        $user->assignRole('editor');

        $this->actingAs($user)->getJson('/api/notification-settings')->assertForbidden();
    }

    public function test_admin_can_view_and_update_notification_settings(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->actingAs($user)->getJson('/api/notification-settings')->assertOk();

        $response = $this->actingAs($user)->putJson('/api/notification-settings', [
            'smtp_enabled' => true,
            'smtp_host' => 'smtp.example.com',
            'smtp_port' => 587,
            'smtp_encryption' => 'tls',
            'smtp_username' => 'alerts@example.com',
            'smtp_password' => 'super-secret',
            'smtp_from_address' => 'alerts@example.com',
            'smtp_from_name' => 'Monitoring',
            'telegram_enabled' => true,
            'telegram_bot_token' => 'bot-token-123',
            'telegram_chat_id' => '12345',
        ]);

        $response->assertOk();
        $response->assertJsonPath('smtp_host', 'smtp.example.com');
    }

    public function test_secrets_are_masked_in_response(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->putJson('/api/notification-settings', [
            'smtp_password' => 'super-secret',
            'telegram_bot_token' => 'bot-token-123',
        ]);

        $response->assertOk();
        $this->assertStringNotContainsString('super-secret', $response->getContent());
        $this->assertStringNotContainsString('bot-token-123', $response->getContent());
        $response->assertJsonPath('smtp_password', '••••••••');
        $response->assertJsonPath('smtp_password_set', true);
    }

    public function test_updating_without_secret_keeps_existing_encrypted_value(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->actingAs($user)->putJson('/api/notification-settings', [
            'smtp_password' => 'original-secret',
        ])->assertOk();

        $this->actingAs($user)->putJson('/api/notification-settings', [
            'smtp_host' => 'smtp2.example.com',
        ])->assertOk();

        $this->assertSame('original-secret', NotificationSetting::getSettings()->smtp_password);
    }

    public function test_test_email_endpoint_returns_failure_gracefully_on_bad_host(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        NotificationSetting::query()->create([
            'smtp_enabled' => true,
            'smtp_host' => 'nonexistent.invalid.host.example',
            'smtp_port' => 587,
        ]);

        $response = $this->actingAs($user)->postJson('/api/notification-settings/test-email');

        $response->assertStatus(422);
    }
}

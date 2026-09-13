<?php

namespace Tests\Feature\Notifications;

use App\Models\NotificationSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ActivityNotifierTest extends TestCase
{
    use RefreshDatabase;

    private function enableTelegram(): void
    {
        NotificationSetting::getSettings()->update([
            'telegram_enabled' => true,
            'telegram_bot_token' => 'test-token',
            'telegram_chat_id' => '-100123',
        ]);
    }

    private function loginPayload(User $user, string $password = 'password'): array
    {
        return ['email' => $user->email, 'password' => $password];
    }

    public function test_login_sends_a_telegram_notification_naming_the_user(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true])]);
        $this->enableTelegram();
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->postJson('/api/login', $this->loginPayload($user))->assertOk();

        Http::assertSent(fn ($request) => str_contains($request->url(), 'api.telegram.org')
            && str_contains($request['text'], $user->email)
            && str_contains($request['text'], 'logged in'));
    }

    public function test_logout_sends_a_telegram_notification(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true])]);
        $this->enableTelegram();
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $this->withHeader('Authorization', "Bearer {$token}")->postJson('/api/logout')->assertOk();

        Http::assertSent(fn ($request) => str_contains($request['text'] ?? '', 'logged out'));
    }

    public function test_no_notification_sent_when_telegram_is_disabled(): void
    {
        Http::fake();
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->postJson('/api/login', $this->loginPayload($user))->assertOk();

        Http::assertNothingSent();
    }

    public function test_telegram_failure_does_not_break_the_login_response(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => false, 'description' => 'boom'], 400)]);
        $this->enableTelegram();
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->postJson('/api/login', $this->loginPayload($user))->assertOk();
    }

    public function test_creating_a_project_sends_a_telegram_notification(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true])]);
        $this->enableTelegram();
        $user = User::factory()->create();

        $this->actingAs($user)->postJson('/api/projects', ['title' => 'New Portfolio Site'])->assertCreated();

        Http::assertSent(fn ($request) => str_contains($request['text'] ?? '', 'New Portfolio Site')
            && str_contains($request['text'], 'Project'));
    }

    public function test_uploading_a_file_sends_a_telegram_notification(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true])]);
        $this->enableTelegram();
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('photo.jpg');
        $this->actingAs($user)->postJson('/api/upload/image', ['image' => $file])->assertOk();

        Http::assertSent(fn ($request) => str_contains($request['text'] ?? '', 'uploaded a file'));
    }

    /**
     * @return array<string, array{0: string, 1: array, 2: string}>
     */
    public static function contentCreationRoutes(): array
    {
        return [
            'service' => ['/api/services', ['title' => 'Cloud Consulting'], 'Cloud Consulting'],
            'post' => ['/api/posts', ['title' => 'Launch Announcement'], 'Launch Announcement'],
            'testimonial' => ['/api/testimonials', ['client_name' => 'Jane Doe', 'client_role' => 'CEO', 'quote' => 'Great work'], 'Jane Doe'],
            'product' => ['/api/products', ['title' => 'Flagship App', 'description' => 'desc'], 'Flagship App'],
            'team-member' => ['/api/team-members', ['name' => 'John Smith', 'position' => 'Engineer'], 'John Smith'],
            'office-location' => ['/api/office-locations', ['name' => 'Nairobi HQ', 'address' => '123 Main St'], 'Nairobi HQ'],
        ];
    }

    #[DataProvider('contentCreationRoutes')]
    public function test_creating_content_sends_a_telegram_notification(string $endpoint, array $payload, string $expectedInMessage): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true])]);
        $this->enableTelegram();
        $user = User::factory()->create();

        $this->actingAs($user)->postJson($endpoint, $payload)->assertCreated();

        Http::assertSent(fn ($request) => str_contains($request['text'] ?? '', $expectedInMessage));
    }
}

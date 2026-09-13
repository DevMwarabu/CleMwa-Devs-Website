<?php

namespace Tests\Feature\Content;

use App\Models\FlagshipProduct;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinksFieldTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_product_can_be_created_with_multiple_store_links(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->postJson('/api/products', [
            'title' => 'Vendility POS',
            'description' => 'POS app',
            'links' => [
                ['label' => 'Google Play', 'url' => 'https://play.google.com/store/apps/details?id=com.vendora.vendora'],
                ['label' => 'App Store', 'url' => 'https://apps.apple.com/us/app/vendility-pos/id6799437523'],
            ],
        ]);

        $response->assertCreated();
        $product = FlagshipProduct::first();
        $this->assertCount(2, $product->links);
        $this->assertSame('Google Play', $product->links[0]['label']);
    }

    public function test_project_can_be_created_with_multiple_store_links(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->postJson('/api/projects', [
            'title' => 'Vendility POS',
            'links' => [
                ['label' => 'Google Play', 'url' => 'https://play.google.com/store/apps/details?id=com.vendora.vendora'],
                ['label' => 'App Store', 'url' => 'https://apps.apple.com/us/app/vendility-pos/id6799437523'],
            ],
        ]);

        $response->assertCreated();
        $project = Project::first();
        $this->assertCount(2, $project->links);
    }

    public function test_a_link_missing_a_url_fails_validation(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->postJson('/api/products', [
            'title' => 'Broken', 'description' => 'x',
            'links' => [['label' => 'Google Play']],
        ]);

        $response->assertStatus(422);
    }
}

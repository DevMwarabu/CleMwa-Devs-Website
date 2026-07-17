<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Basic Details
            $table->string('title')->after('id');
            $table->string('slug')->unique()->after('title');
            $table->string('category')->nullable()->after('slug');
            $table->text('short_description')->nullable()->after('category');
            $table->string('version')->nullable()->after('short_description');
            $table->decimal('rating', 3, 1)->default(5.0)->after('version');
            
            // Content
            $table->longText('overview')->nullable()->after('rating');
            $table->longText('changelog')->nullable()->after('overview');
            
            // Media
            $table->string('logo_url')->nullable()->after('changelog');
            $table->string('cover_image_url')->nullable()->after('logo_url');
            $table->json('gallery')->nullable()->after('cover_image_url');
            $table->json('screenshots')->nullable()->after('gallery');
            
            // Classifications
            $table->json('platforms')->nullable()->after('screenshots');
            $table->boolean('is_featured')->default(false)->after('platforms');
            
            // JSON Repeaters
            $table->json('features')->nullable()->after('is_featured');
            $table->json('modules')->nullable()->after('features');
            $table->json('integrations')->nullable()->after('modules');
            $table->json('pricing_tiers')->nullable()->after('integrations');
            $table->json('stats')->nullable()->after('pricing_tiers');
            $table->json('faqs')->nullable()->after('stats');
            $table->json('documentation')->nullable()->after('faqs');
            $table->json('testimonials')->nullable()->after('documentation');
            
            // SEO
            $table->string('seo_title')->nullable()->after('testimonials');
            $table->text('seo_description')->nullable()->after('seo_title');
            
            // Ordering
            $table->integer('delay')->default(0)->after('seo_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'title', 'slug', 'category', 'short_description', 'version', 'rating',
                'overview', 'changelog', 'logo_url', 'cover_image_url', 'gallery', 'screenshots',
                'platforms', 'is_featured', 'features', 'modules', 'integrations', 'pricing_tiers',
                'stats', 'faqs', 'documentation', 'testimonials', 'seo_title', 'seo_description', 'delay'
            ]);
        });
    }
};

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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title')->nullable();
            $table->text('short_description')->after('subtitle')->nullable();
            $table->json('gallery')->after('image_url')->nullable();
            $table->json('technologies')->after('tags')->nullable();
            $table->json('features_delivered')->after('results')->nullable();
            $table->json('stats')->after('features_delivered')->nullable();
            $table->string('completion_year')->after('status')->nullable();
            $table->date('completion_date')->after('completion_year')->nullable();
            $table->string('status')->default('completed')->after('client_name');
            $table->boolean('is_featured')->default(false)->after('requires_quote');
            $table->string('client_logo_url')->after('client_name')->nullable();
            $table->string('live_url')->after('color_theme')->nullable();
            
            // Testimonial fields
            $table->string('testimonial_name')->nullable();
            $table->string('testimonial_role')->nullable();
            $table->string('testimonial_company')->nullable();
            $table->text('testimonial_quote')->nullable();
            $table->string('testimonial_photo_url')->nullable();
            $table->integer('testimonial_rating')->default(5);
            
            // SEO
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'short_description', 'gallery', 'technologies', 'features_delivered', 
                'stats', 'completion_year', 'completion_date', 'status', 'is_featured', 
                'client_logo_url', 'live_url', 'testimonial_name', 'testimonial_role', 
                'testimonial_company', 'testimonial_quote', 'testimonial_photo_url', 
                'testimonial_rating', 'seo_title', 'seo_description'
            ]);
        });
    }
};

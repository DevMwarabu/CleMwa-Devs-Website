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
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            
            // General Inquiries
            $table->string('general_email')->nullable();
            $table->string('general_phone')->nullable();
            
            // Sales
            $table->string('sales_email')->nullable();
            $table->string('sales_phone')->nullable();
            
            // Technical Support
            $table->string('support_email')->nullable();
            $table->string('help_desk_url')->nullable();
            
            // Partnerships & Careers
            $table->string('partnership_email')->nullable();
            $table->string('careers_email')->nullable();
            
            // Social Media (JSON)
            $table->json('social_links')->nullable();
            
            // SEO
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_settings');
    }
};

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
        Schema::create('about_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->text('overview')->nullable();
            $table->text('our_story')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->text('development_philosophy')->nullable();
            $table->text('culture_description')->nullable();
            $table->text('careers_preview')->nullable();
            $table->string('cta_heading')->nullable();
            $table->text('cta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_settings');
    }
};

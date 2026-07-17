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
        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('service_category_id')->nullable()->constrained('service_categories')->nullOnDelete();
            $table->text('short_description')->nullable();
            $table->longText('detailed_description')->nullable();
            $table->json('key_features')->nullable();
            $table->json('business_benefits')->nullable();
            $table->string('typical_timeline')->nullable();
            $table->string('starting_price')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['service_category_id']);
            $table->dropColumn([
                'service_category_id',
                'short_description',
                'detailed_description',
                'key_features',
                'business_benefits',
                'typical_timeline',
                'starting_price',
                'is_featured',
                'seo_title',
                'seo_description'
            ]);
        });
    }
};

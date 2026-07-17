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
        Schema::table('job_listings', function (Blueprint $table) {
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->string('employment_type')->nullable();
            $table->longText('description')->nullable();
            $table->json('requirements')->nullable();
            $table->longText('responsibilities')->nullable();
            $table->string('salary_range')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('posted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'slug',
                'department',
                'location',
                'employment_type',
                'description',
                'requirements',
                'responsibilities',
                'salary_range',
                'is_active',
                'posted_at',
            ]);
        });
    }
};

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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('category')->nullable();
            $table->json('tags')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_avatar')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'slug',
                'excerpt',
                'content',
                'featured_image',
                'category',
                'tags',
                'author_name',
                'author_avatar',
                'is_published',
                'published_at',
            ]);
        });
    }
};

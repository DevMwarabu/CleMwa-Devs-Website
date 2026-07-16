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
            $table->string('slug')->unique()->after('id');
            $table->string('title')->after('slug');
            $table->text('description')->nullable()->after('title');
            $table->longText('content')->nullable()->after('description');
            $table->text('icon_svg')->nullable()->after('content');
            $table->string('color_theme')->default('sky')->after('icon_svg');
            $table->integer('delay')->default(0)->after('color_theme');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['slug', 'title', 'description', 'content', 'icon_svg', 'color_theme', 'delay']);
        });
    }
};

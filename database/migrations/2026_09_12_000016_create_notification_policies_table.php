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
        Schema::create('notification_policies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('priority')->default(100); // lower evaluated first
            $table->string('severity')->nullable(); // null = any
            $table->string('environment')->nullable(); // null = any
            $table->json('tags')->nullable(); // null = any, else overlap match against server tags
            $table->json('channels'); // subset of ['email','telegram']; [] = dashboard only
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_policies');
    }
};

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
        Schema::create('servers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('hostname')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('public_ip')->nullable();
            $table->string('private_ip')->nullable();
            $table->string('os')->nullable();
            $table->string('os_version')->nullable();
            $table->string('kernel_version')->nullable();
            $table->string('architecture')->nullable();
            $table->integer('cpu_cores')->nullable();
            $table->integer('ram_mb')->nullable();
            $table->integer('storage_gb')->nullable();
            $table->string('environment')->default('production');
            $table->string('role')->nullable();
            $table->string('location')->nullable();
            $table->json('tags')->nullable();
            $table->string('agent_version')->nullable();
            $table->timestamp('last_heartbeat_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};

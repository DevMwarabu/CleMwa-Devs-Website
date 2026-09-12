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
        // Current-state snapshot only — one row per server, overwritten on
        // every agent push. Historical time-series storage is a later phase.
        Schema::create('server_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('server_id')->unique()->constrained('servers')->cascadeOnDelete();
            $table->json('cpu')->nullable();
            $table->json('memory')->nullable();
            $table->json('disk')->nullable();
            $table->json('network')->nullable();
            $table->json('processes')->nullable();
            $table->json('services')->nullable();
            $table->timestamp('collected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_metrics');
    }
};

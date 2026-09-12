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
        // Append-only — one row per agent push, unlike server_metrics which
        // overwrites. processes/services are current-state-only concerns and
        // intentionally excluded here to keep history rows lean.
        Schema::create('server_metric_history', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('server_id')->constrained('servers')->cascadeOnDelete();
            $table->json('cpu')->nullable();
            $table->json('memory')->nullable();
            $table->json('disk')->nullable();
            $table->json('network')->nullable();
            $table->timestamp('collected_at');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['server_id', 'collected_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_metric_history');
    }
};

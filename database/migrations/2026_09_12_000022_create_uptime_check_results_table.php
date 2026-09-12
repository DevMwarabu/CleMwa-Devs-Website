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
        // Append-only history, retention-pruned like server_metric_history.
        Schema::create('uptime_check_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uptime_check_id')->constrained('uptime_checks')->cascadeOnDelete();
            $table->integer('status_code')->nullable();
            $table->integer('response_time_ms')->nullable();
            $table->boolean('success');
            $table->timestamp('ssl_expires_at')->nullable();
            $table->text('error')->nullable();
            $table->timestamp('checked_at');

            $table->index(['uptime_check_id', 'checked_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uptime_check_results');
    }
};

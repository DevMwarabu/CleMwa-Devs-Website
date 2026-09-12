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
        // Current state only, one row per rule x server — mirrors the
        // server_metrics current-state pattern rather than history.
        Schema::create('alert_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alert_rule_id')->constrained('alert_rules')->cascadeOnDelete();
            $table->foreignUuid('server_id')->constrained('servers')->cascadeOnDelete();
            $table->string('state')->default('normal'); // normal|pending|firing|resolved
            $table->timestamp('breach_started_at')->nullable();
            $table->timestamp('fired_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->decimal('current_value', 10, 2)->nullable();
            $table->timestamp('last_evaluated_at')->nullable();
            $table->timestamps();

            $table->unique(['alert_rule_id', 'server_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_states');
    }
};

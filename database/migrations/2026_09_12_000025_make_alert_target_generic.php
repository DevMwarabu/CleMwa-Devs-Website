<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Alerts can now target either a Server (unchanged) or an UptimeCheck
     * (new, Phase 9) — exactly one of server_id/uptime_check_id is set per
     * row. server_id becomes nullable rather than duplicating the entire
     * state-machine schema for a second target type.
     */
    public function up(): void
    {
        Schema::table('alert_states', function (Blueprint $table) {
            $table->foreignUuid('server_id')->nullable()->change();
            $table->foreignId('uptime_check_id')->nullable()->after('server_id')->constrained('uptime_checks')->cascadeOnDelete();
            // Postgres treats NULL as distinct in unique indexes, so the
            // original unique(alert_rule_id, server_id) alone wouldn't stop
            // duplicate rows for different uptime checks (all server_id=null).
            $table->unique(['alert_rule_id', 'uptime_check_id'], 'alert_states_rule_uptime_unique');
        });

        Schema::table('alert_events', function (Blueprint $table) {
            $table->foreignUuid('server_id')->nullable()->change();
            $table->foreignId('uptime_check_id')->nullable()->after('server_id')->constrained('uptime_checks')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alert_states', function (Blueprint $table) {
            $table->dropUnique('alert_states_rule_uptime_unique');
            $table->dropConstrainedForeignId('uptime_check_id');
            $table->foreignUuid('server_id')->nullable(false)->change();
        });

        Schema::table('alert_events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('uptime_check_id');
            $table->foreignUuid('server_id')->nullable(false)->change();
        });
    }
};

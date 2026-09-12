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
        Schema::table('alert_states', function (Blueprint $table) {
            $table->timestamp('last_notified_at')->nullable()->after('resolved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alert_states', function (Blueprint $table) {
            $table->dropColumn('last_notified_at');
        });
    }
};

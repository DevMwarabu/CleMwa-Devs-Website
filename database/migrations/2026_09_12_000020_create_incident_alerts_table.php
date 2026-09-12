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
        // Links an incident to the alert_events that contributed to it —
        // the timeline of firing/resolved transitions for its rule+server.
        Schema::create('incident_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_id')->constrained('incidents')->cascadeOnDelete();
            $table->foreignId('alert_event_id')->constrained('alert_events')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['incident_id', 'alert_event_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_alerts');
    }
};

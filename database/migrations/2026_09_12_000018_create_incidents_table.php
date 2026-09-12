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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('severity');
            $table->foreignUuid('server_id')->constrained('servers')->cascadeOnDelete();
            $table->foreignId('alert_rule_id')->nullable()->constrained('alert_rules')->nullOnDelete();
            $table->string('status')->default('open'); // open|acknowledged|investigating|resolved
            $table->timestamp('started_at');
            $table->timestamp('resolved_at')->nullable();
            $table->foreignUuid('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['alert_rule_id', 'server_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};

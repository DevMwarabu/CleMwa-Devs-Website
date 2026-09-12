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
        Schema::create('alert_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('metric'); // cpu_percent|memory_percent|disk_percent|server_offline|service_down
            $table->foreignUuid('server_id')->nullable()->constrained('servers')->cascadeOnDelete();
            $table->string('service_name')->nullable();
            $table->string('condition')->nullable(); // >, <, >=, <=
            $table->decimal('threshold', 8, 2)->nullable();
            $table->integer('for_duration_seconds')->default(300);
            $table->string('severity')->default('warning'); // info|warning|high|critical
            $table->boolean('enabled')->default(true);
            $table->json('labels')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_rules');
    }
};

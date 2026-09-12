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
        Schema::create('uptime_checks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('method')->default('GET');
            $table->json('headers')->nullable();
            $table->text('body')->nullable();
            $table->integer('expected_status')->default(200);
            $table->string('expected_body_contains')->nullable();
            $table->integer('check_interval_seconds')->default(60);
            $table->boolean('enabled')->default(true);
            // Current-state mirror (matches the servers/server_metrics pattern) so
            // the list page doesn't need a join to show live status.
            $table->boolean('last_success')->nullable();
            $table->integer('last_response_time_ms')->nullable();
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamp('ssl_expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uptime_checks');
    }
};

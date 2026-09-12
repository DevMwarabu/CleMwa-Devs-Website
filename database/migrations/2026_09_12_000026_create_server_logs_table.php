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
        Schema::create('server_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('server_id')->constrained('servers')->cascadeOnDelete();
            $table->string('source'); // e.g. "/var/log/nginx/error.log" or "journalctl:nginx"
            $table->string('level')->default('INFO'); // heuristically parsed server-side, not by the agent
            $table->text('message');
            $table->timestamp('logged_at'); // when the agent collected it, not a parsed in-line timestamp (formats vary too widely to trust)
            $table->timestamp('created_at')->useCurrent();

            $table->index(['server_id', 'logged_at']);
            $table->index('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_logs');
    }
};

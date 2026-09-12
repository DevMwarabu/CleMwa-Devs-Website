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
        Schema::create('notification_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('channel'); // email|telegram
            $table->foreignUuid('server_id')->nullable()->constrained('servers')->nullOnDelete();
            $table->json('alert_event_ids')->nullable(); // grouped: may cover several transitions
            $table->string('recipient')->nullable();
            $table->string('status'); // delivered|failed
            $table->text('error')->nullable();
            $table->timestamp('attempted_at');
            $table->timestamp('delivered_at')->nullable();
            $table->integer('retry_count')->default(0);

            $table->index(['channel', 'status']);
            $table->index('attempted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_deliveries');
    }
};

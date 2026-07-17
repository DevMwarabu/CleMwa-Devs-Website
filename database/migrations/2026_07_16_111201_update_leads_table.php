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
        Schema::table('leads', function (Blueprint $table) {
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('type')->default('inquiry');
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->string('source')->nullable();
            $table->string('status')->default('new');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'email',
                'phone',
                'company',
                'type',
                'subject',
                'message',
                'source',
                'status',
                'notes',
            ]);
        });
    }
};

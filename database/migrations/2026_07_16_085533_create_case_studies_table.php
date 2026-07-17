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
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('slug')->unique();
            $table->string('industry')->nullable();
            $table->string('client_name')->nullable();
            $table->text('challenge')->nullable();
            $table->text('solution')->nullable();
            $table->json('technologies')->nullable();
            $table->text('project_outcome')->nullable();
            $table->string('image_url')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('order_column')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};

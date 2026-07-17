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
        Schema::table('office_locations', function (Blueprint $table) {
            $table->string('city')->nullable()->after('address');
            $table->string('country')->nullable()->after('city');
            $table->string('fax')->nullable()->after('phone');
            $table->text('working_hours')->nullable()->after('office_hours');
            $table->boolean('is_primary')->default(false)->after('order_column');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('office_locations', function (Blueprint $table) {
            $table->dropColumn(['city', 'country', 'fax', 'working_hours', 'is_primary']);
        });
    }
};

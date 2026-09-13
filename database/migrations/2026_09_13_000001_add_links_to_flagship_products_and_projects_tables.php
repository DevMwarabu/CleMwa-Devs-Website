<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A repeatable list of {label, url} links — e.g. a Google Play link and
     * an App Store link for the same product, which the single demo_link/
     * details_link (Products) or live_url (Projects) columns can't hold.
     */
    public function up(): void
    {
        Schema::table('flagship_products', function (Blueprint $table) {
            $table->json('links')->nullable()->after('details_link');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->json('links')->nullable()->after('live_url');
        });
    }

    public function down(): void
    {
        Schema::table('flagship_products', function (Blueprint $table) {
            $table->dropColumn('links');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('links');
        });
    }
};

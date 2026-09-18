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
        if (Schema::hasTable('services')) {
            Schema::table('services', function (Blueprint $table) {
                if (!Schema::hasColumn('services', 'pricing_matrix')) {
                    $table->json('pricing_matrix')->nullable()->after('flat_price');
                }
            });
        }

        if (Schema::hasTable('service_options')) {
            Schema::table('service_options', function (Blueprint $table) {
                if (!Schema::hasColumn('service_options', 'pricing_matrix')) {
                    $table->json('pricing_matrix')->nullable()->after('price');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('services')) {
            Schema::table('services', function (Blueprint $table) {
                if (Schema::hasColumn('services', 'pricing_matrix')) {
                    $table->dropColumn('pricing_matrix');
                }
            });
        }

        if (Schema::hasTable('service_options')) {
            Schema::table('service_options', function (Blueprint $table) {
                if (Schema::hasColumn('service_options', 'pricing_matrix')) {
                    $table->dropColumn('pricing_matrix');
                }
            });
        }
    }
};
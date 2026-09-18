<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_records', function (Blueprint $table) {
            if (!Schema::hasColumn('service_records', 'selected_services_prices')) {
                $table->json('selected_services_prices')->nullable()->after('selected_services');
            }
        });
    }

    public function down(): void
    {
        Schema::table('service_records', function (Blueprint $table) {
            if (Schema::hasColumn('service_records', 'selected_services_prices')) {
                $table->dropColumn('selected_services_prices');
            }
        });
    }
};
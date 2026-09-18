<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_records', function (Blueprint $table) {
            if (!Schema::hasColumn('service_records', 'contact_number')) {
                $table->string('contact_number')->nullable()->after('customer_name');
            }
            if (!Schema::hasColumn('service_records', 'vehicle_make')) {
                $table->string('vehicle_make')->nullable()->after('contact_number');
            }
            if (!Schema::hasColumn('service_records', 'vehicle_type')) {
                $table->string('vehicle_type')->nullable()->after('vehicle_model');
            }
            if (!Schema::hasColumn('service_records', 'vehicle_year')) {
                $table->string('vehicle_year')->nullable()->after('vehicle_type');
            }
            if (!Schema::hasColumn('service_records', 'price_adjustment_note')) {
                $table->text('price_adjustment_note')->nullable()->after('total_cost');
            }
        });
    }

    public function down(): void
    {
        Schema::table('service_records', function (Blueprint $table) {
            $columnsToDrop = array_filter([
                'contact_number',
                'vehicle_make',
                'vehicle_type',
                'vehicle_year',
                'price_adjustment_note',
            ], fn($column) => Schema::hasColumn('service_records', $column));

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
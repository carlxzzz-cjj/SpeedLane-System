<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('service_options', function (Blueprint $table) {
            if (!Schema::hasColumn('service_options', 'vehicle_type')) {
                $table->string('vehicle_type')->nullable();
            }
            if (!Schema::hasColumn('service_options', 'pricing_matrix')) {
                $table->text('pricing_matrix')->nullable();
            }
        });
    }

    public function down(): void {
        Schema::table('service_options', function (Blueprint $table) {
            $table->dropColumn(['vehicle_type', 'pricing_matrix']);
        });
    }
};
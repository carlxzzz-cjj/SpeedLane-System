<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'vehicle_type')) {
                $table->string('vehicle_type')->nullable();
            }
            if (!Schema::hasColumn('services', 'pricing_matrix')) {
                $table->text('pricing_matrix')->nullable();
            }
            if (!Schema::hasColumn('services', 'notice')) {
                $table->text('notice')->nullable();
            }
        });
    }

    public function down(): void {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['vehicle_type', 'pricing_matrix', 'notice']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_models', function (Blueprint $table) {
            if (Schema::hasColumn('vehicle_models', 'year_model')) {
                $table->dropColumn('year_model');
            }
            $table->integer('year_start')->nullable()->after('vehicle_type');
            $table->integer('year_end')->nullable()->after('year_start');
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_models', function (Blueprint $table) {
            $table->dropColumn(['year_start', 'year_end']);
            $table->string('year_model')->nullable()->after('vehicle_type');
        });
    }
};
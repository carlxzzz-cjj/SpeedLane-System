<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_records', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('tracking_code');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->nullable()->after('middle_name');
            $table->string('suffix')->nullable()->after('last_name');
        });

        // Migrate existing customer_name data into first_name to preserve old data
        DB::table('service_records')->whereNotNull('customer_name')->update([
            'first_name' => DB::raw('customer_name')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_records', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'middle_name', 'last_name', 'suffix']);
        });
    }
};
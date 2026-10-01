<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('name');
            $table->string('vehicle_type')->nullable(); // <-- Add this column
            $table->string('year_model')->nullable();   //[cite: 21]
            $table->timestamps();                       //[cite: 21]
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_models'); //[cite: 21]
    }
};
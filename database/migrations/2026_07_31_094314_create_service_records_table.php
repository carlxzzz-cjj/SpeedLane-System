<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to build the table structure.
     */
    public function up(): void
    {
        Schema::create('service_records', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key to Users table (replaces customer_name)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Tracking Code (Indexed for fast lookups & grouping multiple vehicles under one transaction)
            $table->string('tracking_code')->index(); 
            
            // Customer Contact Details (Name can now be retrieved dynamically via the user relationship)
            $table->string('contact_number')->nullable();
            
            // Vehicle Details
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_year')->nullable();
            $table->string('plate_number')->index();
            
            // Services & Pricing Breakdown
            $table->json('selected_services'); 
            $table->json('selected_services_prices')->nullable();
            $table->text('price_adjustment_note')->nullable();
            $table->decimal('total_cost', 10, 2)->default(0.00); 
            
            // Assignment & Tracking
            $table->string('mechanic_assigned')->default('Unassigned'); 
            $table->string('status')->default('Pending')->index(); 
            
            $table->timestamps();
            $table->softDeletes(); // Safe deletion audit trail
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_records');
    }
};
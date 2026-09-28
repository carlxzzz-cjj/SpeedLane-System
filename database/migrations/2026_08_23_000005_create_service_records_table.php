<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('service_records', function (Blueprint $table) {
        $table->id();
        
        // Foreign Keys
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
        $table->foreignId('technician_id')->nullable()->constrained('technicians')->onDelete('set null');
        
        // Ticket & Customer Details
        $table->string('tracking_code');
        $table->string('customer_name')->nullable();
        $table->string('contact_number')->nullable();
        
        // Vehicle Specs
        $table->string('vehicle_make')->nullable();
        $table->string('vehicle_model')->nullable();
        $table->string('vehicle_type')->nullable();
        $table->string('vehicle_year')->nullable();
        $table->string('plate_number');
        
        // Service Breakdown & Cost
        $table->json('selected_services');
        $table->json('selected_services_prices')->nullable();
        $table->text('price_adjustment_note')->nullable();
        $table->decimal('total_cost', 10, 2)->default(0.00);
        $table->string('mechanic_assigned')->default('Unassigned');
        $table->string('status')->default('Queued');
        
        $table->timestamps();
        $table->softDeletes();
    });
}
};
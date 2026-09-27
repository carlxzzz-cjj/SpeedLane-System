<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServiceRecordsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('service_records')->delete();
        
        \DB::table('service_records')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tracking_code' => 'SPD26-HPB9ZS',
                'customer_name' => 'Carl Andres Jay Malabarbas',
                'contact_number' => '09361618643',
                'vehicle_make' => 'Toyota',
                'vehicle_model' => 'Fortuner',
                'vehicle_type' => 'SUV',
                'vehicle_year' => '2024',
                'plate_number' => 'BBC-445',
                'selected_services' => '[{"name":"Interior Detailing","status":"Completed & Ready for Pickup","note":""}]',
                'selected_services_prices' => '{"Interior Detailing":6500}',
                'price_adjustment_note' => NULL,
                'total_cost' => '6500.00',
                'mechanic_assigned' => 'Cedrick Mostacho',
                'status' => 'Completed',
                'created_at' => '2026-09-27 17:18:18',
                'updated_at' => '2026-09-27 17:19:22',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}
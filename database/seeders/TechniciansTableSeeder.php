<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TechniciansTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('technicians')->delete();
        
        \DB::table('technicians')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Carl Andres Jay Malabarbas',
                'is_active' => 1,
                'disabled_at' => NULL,
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Cedrick Mostacho',
                'is_active' => 1,
                'disabled_at' => NULL,
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 12:51:22',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Gience Fyke Paras',
                'is_active' => 0,
                'disabled_at' => '2026-09-27 17:35:02',
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 17:35:02',
            ),
        ));
        
        
    }
}
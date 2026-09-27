<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            ServicesTableSeeder::class,
            ServiceOptionsTableSeeder::class,
            TechniciansTableSeeder::class,
            VehicleModelsTableSeeder::class,
            ServiceRecordsTableSeeder::class,
        ]);
        $this->call(UsersTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(ServiceOptionsTableSeeder::class);
        $this->call(ServiceRecordsTableSeeder::class);
        $this->call(TechniciansTableSeeder::class);
        $this->call(VehicleModelsTableSeeder::class);
    }
}
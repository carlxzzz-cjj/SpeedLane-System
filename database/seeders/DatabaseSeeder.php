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
            VehicleModelSeeder::class,
        ]);
        $this->call(UsersTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(ServiceOptionsTableSeeder::class);
        $this->call(TechniciansTableSeeder::class);
        $this->call(VehicleModelSeeder::class);
    }
}
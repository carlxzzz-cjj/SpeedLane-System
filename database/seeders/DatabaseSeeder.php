<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Fallback Super Admin (Ensures login access no matter what)
        User::updateOrCreate(
            ['email' => 'superadmin@speedlane.com'],
            [
                'name'           => 'Super Admin',
                'username'       => 'superadmin',
                'contact_number' => '09123456789',
                'password'       => Hash::make('Password123'),
                'role'           => 'super_admin',
                'is_super_admin' => true,
            ]
        );

        // 2. Load all local database data exported by iseed (in correct dependency order)
        $this->call([
            UsersTableSeeder::class,
            ServicesTableSeeder::class,
            ServiceOptionsTableSeeder::class,
            TechniciansTableSeeder::class,
            VehicleModelsTableSeeder::class,
            ServiceRecordsTableSeeder::class,
        ]);
    }
}
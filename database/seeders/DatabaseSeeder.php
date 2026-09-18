<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Technician;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create or Update Super Admin Account
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

        // Seed Sample Technicians
        $technicians = ['John Doe', 'Alex Smith', 'Robert Johnson'];
        foreach ($technicians as $tech) {
            Technician::firstOrCreate(['name' => $tech]);
        }
    }
}
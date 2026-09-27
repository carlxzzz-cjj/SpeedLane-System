<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Carl Andres Jay Malabarbas',
                'email' => '2023_cete_malabarbascar@online.htcgsc.edu.ph',
                'contact_number' => '09171234567',
                'username' => 'carl_superadmin',
                'password' => '$2y$12$MBBQyfHLxNUVfXz0iahRHOjrPfDBdvyx4Da.Z93jEtb3oWsLPcHoS',
                'remember_token' => NULL,
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 19:20:39',
                'role' => 'super_admin',
                'is_super_admin' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Cedrick Mostacho',
                'email' => 'malabarbascarlandresjay@gmail.com',
                'contact_number' => '09177654321',
                'username' => 'cedrick_admin',
                'password' => '$2y$12$UdGzZROoSonHl/yTTb1SXeay3mXNBBPUd67Ageizkyt.fLIYTgo8y',
                'remember_token' => NULL,
                'created_at' => '2026-09-27 12:51:22',
                'updated_at' => '2026-09-27 19:23:27',
                'role' => 'admin',
                'is_super_admin' => 0,
            ),
            2 => 
            array (
                'id' => 5,
                'name' => 'Andreo Kent Tarre',
                'email' => 'carlandresjay@gmail.com',
                'contact_number' => '093677452372',
                'username' => 'dreooo',
                'password' => '$2y$12$jhSiKt4XnKMNTZFttZV9q.smUBrFZFJt4V/zdgacxcthAXGWGLOvG',
                'remember_token' => NULL,
                'created_at' => '2026-09-27 18:53:24',
                'updated_at' => '2026-09-27 19:03:27',
                'role' => 'admin',
                'is_super_admin' => 0,
            ),
        ));
        
        
    }
}
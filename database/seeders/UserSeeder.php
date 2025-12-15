<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UserSeeder.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Updated admin user seeding to include required QPK fields |
 * 
 */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the main Admin user
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'phone_number' => '7223456789', 
            'email' => 'admin@volt.com',
            'password' => Hash::make('admin123'),
            'credit' => 1000.00, 
            'platform' => 'web',
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Daniel',
            'last_name' => 'Yair Mendoza',
            'phone_number' => '7221234567', 
            'email' => 'daniel@gmail.com',
            'password' => Hash::make('daniel123'),
            'credit' => 1000.00, 
            'platform' => 'web',
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Juan',
            'last_name' => 'Martinez',
            'phone_number' => '7229876543', 
            'email' => 'juan@gmail.com',
            'password' => Hash::make('juan123'),
            'credit' => 1000.00, 
            'platform' => 'mobile',
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Miguel',
            'last_name' => 'Hernandez',
            'phone_number' => '7225647382', 
            'email' => 'miguel@gmail.com',
            'password' => Hash::make('miguel123'),
            'credit' => 1000.00, 
            'platform' => 'mobile',
            'email_verified_at' => now(),
        ]);

    }
}

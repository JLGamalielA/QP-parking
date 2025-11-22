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
 * Description: Updated admin user seeding to include required QPK fields. |
 */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'birth_date' => '1990-01-01', // Default administrative date
            'phone_number' => '5555555555', // Default dummy phone
            'email' => 'admin@volt.com',
            'password' => Hash::make('abc123'),
            'credit' => 1000.00, // Initial credit for admin testing
            'email_verified_at' => now(),
        ]);
    }
}

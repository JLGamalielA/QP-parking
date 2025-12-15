<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SpecialParkingRoleSeeder.php
 * Created on: 14/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 14/12/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Seeder to create a special parking role for Daniel's parking |
 * 
 */

namespace Database\Seeders;

use App\Models\Parking;
use App\Models\SpecialParkingRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialParkingRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'daniel@gmail.com')->first();

        if ($user) {
            $parking = Parking::where('user_id', $user->user_id)->first();

            if ($parking) {
                SpecialParkingRole::firstOrCreate(
                    [
                        'parking_id' => $parking->parking_id,
                        'type' => 'Proveedor Local'
                    ],
                    [
                        'special_commission_period' => 3600,
                        'special_commission_value' => 15.00,
                    ]
                );
            }
        }
    }
}

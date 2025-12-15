<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SpecialUserApplicationSeeder.php
 * Created on: 14/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 14/12/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Seeder to create special user applications for Juan and Miguel |
 * 
 */

namespace Database\Seeders;

use App\Models\Parking;
use App\Models\SpecialParkingRole;
use App\Models\SpecialUserApplication;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialUserApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::where('email', 'daniel@gmail.com')->first();

        if (! $owner) {
            return;
        }

        $parking = Parking::where('user_id', $owner->user_id)->first();

        if (! $parking) {
            return;
        }

        $role = SpecialParkingRole::where('parking_id', $parking->parking_id)->first();

        if (! $role) {
            return;
        }

        $applicants = ['juan@gmail.com', 'miguel@gmail.com'];

        foreach ($applicants as $email) {
            $user = User::where('email', $email)->first();

            if ($user) {
                SpecialUserApplication::firstOrCreate(
                    [
                        'parking_id' => $parking->parking_id,
                        'user_id' => $user->user_id
                    ],
                    [
                        'special_parking_role_id' => $role->special_parking_role_id
                    ]
                );
            }
        }
    }
}

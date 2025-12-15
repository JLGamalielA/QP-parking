<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingSeeder.php
 * Created on: 14/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 14/12/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Seeder to create the initial parking and its schedules for user Daniel |
 * 
 */

namespace Database\Seeders;

use App\Models\Parking;
use App\Models\ParkingSchedule;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'daniel@gmail.com')->first();

        if ($user) {
            $parking = Parking::firstOrCreate(
                ['user_id' => $user->user_id],
                [
                    'name' => 'Estacionamiento Centro',
                    'type' => 'hour',
                    'price_per_hour' => 35.00,
                    'fixed_price' => null,
                    'latitude' => 19.2683082,
                    'longitude' => -99.6417905,
                ]
            );

            $this->createSchedules($parking->parking_id);
        }
    }

    /**
     * Helper function to create weekly schedules.
     *
     * @param int $parkingId
     */
    private function createSchedules(int $parkingId)
    {
        $days = [0, 1, 2, 3, 4, 5, 6];

        foreach ($days as $day) {
            ParkingSchedule::firstOrCreate(
                [
                    'parking_id' => $parkingId,
                    'weekday' => $day
                ],
                [
                    'is_open' => true,
                    'opening_time' => '08:00:00',
                    'closing_time' => '23:00:00',
                ]
            );
        }
    }
}

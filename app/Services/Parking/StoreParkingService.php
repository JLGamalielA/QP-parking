<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: StoreParkingService.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 * Modified by: Daniel Yair Mendoza Alvarez | 
 * Description: Service to handle parking business logic and transactions. |
 */

namespace App\Services\Parking;

use App\Models\Parking;
use App\Models\ParkingSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreParkingService
{
    /**
     * Creates a new parking record along with its schedules within a transaction.
     *
     * @param array $parkingData Validated parking data.
     * @param array $schedulesData Array of schedule configuration.
     * @return Parking The created parking instance.
     * @throws \Exception If transaction fails.
     */
    public function execute(array $parkingData, array $schedulesData): Parking
    {
        return DB::transaction(function () use ($parkingData, $schedulesData) {
            // Create Parking
            $parking = Parking::create(array_merge(
                $parkingData,
                ['user_id' => Auth::id()]
            ));

            // Create Schedules
            foreach ($schedulesData as $schedule) {
                $isOpen = (bool) ($schedule['is_open'] ?? false);

                ParkingSchedule::create([
                    'parking_id'   => $parking->parking_id,
                    'weekday'      => $schedule['weekday'],
                    'is_open'      => $isOpen,
                    'opening_time' => $isOpen ? $schedule['opening_time'] : null,
                    'closing_time' => $isOpen ? $schedule['closing_time'] : null,
                ]);
            }

            return $parking;
        });
    }
}

<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UpdateParkingService.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 * Modified by: Daniel Yair Mendoza Alvarez | 
 * Description: Service dedicated to the update transaction of Parkings and Schedules (Synchronization). |
 */

namespace App\Services\Parking;

use App\Models\Parking;
use App\Models\ParkingSchedule;
use Illuminate\Support\Facades\DB;

class UpdateParkingService
{
    /**
     * Executes the update of a parking and its schedules atomically.
     *
     * @param Parking $parking The instance to update.
     * @param array $parkingData Validated data for the parking model.
     * @param array $schedulesData Array of schedule configuration from the request.
     * @return Parking The updated instance.
     * @throws \Exception If the database transaction fails.
     */
    public function execute(Parking $parking, array $parkingData, array $schedulesData): Parking
    {
        return DB::transaction(function () use ($parking, $parkingData, $schedulesData) {
            // 1. Update Parking Record
            $parking->update($parkingData);

            // 2. Synchronize Schedule Records (Update or Create)
            foreach ($schedulesData as $scheduleData) {
                $isOpen = (bool) ($scheduleData['is_open'] ?? false);

                // Using updateOrCreate to handle schedules efficiently
                ParkingSchedule::updateOrCreate(
                    [
                        'parking_id' => $parking->parking_id,
                        'weekday' => $scheduleData['weekday']
                    ],
                    [
                        'is_open' => $isOpen,
                        'opening_time' => $isOpen ? $scheduleData['opening_time'] : null,
                        'closing_time' => $isOpen ? $scheduleData['closing_time'] : null,
                    ]
                );
            }

            return $parking;
        });
    }
}

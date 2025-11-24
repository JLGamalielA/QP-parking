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
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Service to handle parking business logic and transactions. |
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

    /**
     * Prepares schedule data for the edit view.
     * Merges database records with default values for all days of the week.
     *
     * @param Parking $parking
     * @return array
     */
    public function prepareScheduleForEdit(Parking $parking): array
    {
        $preparedSchedules = [];
        // Days mapping (0=Domingo to 6=Sábado) as per Carbon/PHP standard
        // Note: Your view array uses 1-6 then 0. Let's stick to your view's order logic in the controller if needed,
        // but standard array manipulation is cleaner.
        $days = [1, 2, 3, 4, 5, 6, 0];

        foreach ($days as $dayKey) {
            // Find existing schedule in the relationship
            $dbSchedule = $parking->schedules->firstWhere('weekday', $dayKey);

            $preparedSchedules[$dayKey] = [
                'is_open' => $dbSchedule ? (bool)$dbSchedule->is_open : false,
                'opening_time' => $dbSchedule && $dbSchedule->opening_time
                    ? \Carbon\Carbon::parse($dbSchedule->opening_time)->format('H:i')
                    : '09:00',
                'closing_time' => $dbSchedule && $dbSchedule->closing_time
                    ? \Carbon\Carbon::parse($dbSchedule->closing_time)->format('H:i')
                    : '17:00',
            ];
        }

        return $preparedSchedules;
    }
}

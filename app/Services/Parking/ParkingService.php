<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingService.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: General parking business logic, including data preparation for views. |
 */

namespace App\Services\Parking;

use App\Models\Parking;
use Illuminate\Support\Carbon;

class ParkingService
{
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
        // Standard week array (1=Monday to 0=Sunday)
        $days = [1, 2, 3, 4, 5, 6, 0];

        foreach ($days as $dayKey) {
            // Find existing schedule in the relationship
            $dbSchedule = $parking->schedules->firstWhere('weekday', $dayKey);

            $preparedSchedules[$dayKey] = [
                'is_open' => $dbSchedule ? (bool)$dbSchedule->is_open : false,
                'opening_time' => $dbSchedule && $dbSchedule->opening_time
                    ? Carbon::parse($dbSchedule->opening_time)->format('H:i')
                    : '09:00',
                'closing_time' => $dbSchedule && $dbSchedule->closing_time
                    ? Carbon::parse($dbSchedule->closing_time)->format('H:i')
                    : '17:00',
            ];
        }

        return $preparedSchedules;
    }

    /**
     * Attempts to delete a parking by its ID.
     *
     * @param int $id
     * @return string Status ('success', 'not_found', 'error')
     */
    public function deleteParkingById(int $id): string
    {
        try {
            $parking = Parking::find($id);

            if (!$parking) {
                return 'not_found';
            }

            $parking->delete();
            return 'success';
        } catch (\Exception $e) {
            // Log error if needed
            return 'error';
        }
    }
}

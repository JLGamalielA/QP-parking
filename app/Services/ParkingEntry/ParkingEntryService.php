<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingEntryService.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Service for managing parking entry scanners business logic. |
 */

namespace App\Services\Parking;

use App\Models\ParkingEntry;
use App\Models\Parking;
use Illuminate\Support\Facades\Auth;

class ParkingEntryService
{
    /**
     * Creates a new parking entry scanner.
     *
     * @param array $data Validated data.
     * @return ParkingEntry
     */
    public function createEntry(array $data): ParkingEntry
    {
        $parking = Parking::where('user_id', Auth::id())->firstOrFail();

        return ParkingEntry::create([
            'parking_id' => $parking->parking_id,
            'name' => $data['name'],
            'is_entry' => $data['type'] === 'entry', // Convert string to boolean
            'is_active' => true, // Default active per business rule
        ]);
    }

    /**
     * Updates an existing parking entry scanner.
     *
     * @param ParkingEntry $entry
     * @param array $data Validated data.
     * @return bool
     */
    public function updateEntry(ParkingEntry $entry, array $data): bool
    {
        return $entry->update([
            'name' => $data['name'],
            'is_entry' => $data['type'] === 'entry',
        ]);
    }

    /**
     * Deletes a parking entry scanner.
     *
     * @param ParkingEntry $entry
     * @return bool|null
     */
    public function deleteEntry(ParkingEntry $entry): ?bool
    {
        return $entry->delete();
    }
}

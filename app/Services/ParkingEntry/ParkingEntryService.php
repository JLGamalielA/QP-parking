<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingEntryService.php
 * Created on: 26/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 26/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Service for managing parking entries (readers) business logic. |
 */

namespace App\Services\ParkingEntry;

use App\Models\Parking;
use App\Models\ParkingEntry;
use Illuminate\Support\Facades\Auth;

class ParkingEntryService
{
    /**
     * Creates a new parking entry (reader).
     *
     * @param array $data
     * @return ParkingEntry
     */
    public function createEntry(array $data): ParkingEntry
    {
        $parking = Parking::where('user_id', Auth::id())->firstOrFail();

        return ParkingEntry::create([
            'parking_id' => $parking->parking_id,
            'name' => $data['name'],
            'is_entry' => (bool) $data['is_entry'],
            'is_active' => true, // Default active
        ]);
    }

    /**
     * Updates an existing parking entry.
     *
     * @param ParkingEntry $entry
     * @param array $data
     * @return bool
     */
    public function updateEntry(ParkingEntry $entry, array $data): bool
    {
        return $entry->update([
            'name' => $data['name'],
            'is_entry' => (bool) $data['is_entry'],
        ]);
    }

    /**
     * Deletes a parking entry safely.
     *
     * @param int $id
     * @return string Status ('success', 'not_found', 'error')
     */
    public function deleteEntryById(int $id): string
    {
        try {
            $entry = ParkingEntry::find($id);

            if (!$entry) {
                return 'not_found';
            }
            if ($entry->activeUserQrScans()->exists()) {
                return 'has_dependencies';
            }

            if ($entry->historyAsEntry()->exists()) {
                return 'has_dependencies';
            }

            if ($entry->historyAsExit()->exists()) {
                return 'has_dependencies';
            }

            $entry->delete();

            return 'success';
        } catch (\Exception $e) {
            return 'error';
        }
    }

    /**
     * Retrieves a specific entry by ID, ensuring it belongs to the user's parking.
     *
     * @param int $id
     * @return ParkingEntry|null
     */
    public function getEntryById(int $id): ?ParkingEntry
    {
        $parking = Parking::where('user_id', Auth::id())->first();

        if (!$parking) {
            return null;
        }
        return ParkingEntry::where('parking_entry_id', $id)
            ->where('parking_id', $parking->parking_id)
            ->first();
    }
}

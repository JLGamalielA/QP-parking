<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ActiveUserQrScanService.php
 * Created on: 26/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 26/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Service for handling QR scan logic (Entry/Exit validation) |
 * 
 */

namespace App\Services\ActiveUserQrScan;

use App\Models\ActiveUserQrScan;
use App\Models\ParkingEntry;
use App\Models\UserExitQrCode;
use Carbon\Carbon;

class ActiveUserQrScanService
{
    /**
     * Process a QR scan from a reader.
     * Determines if it is an Entry or an Exit based on current user state.
     *
     * @param int $userId
     * @param int $parkingId
     * @param int $entryId
     * @return array Response structure with 'ok', 'data' or 'error'
     */
    public function processScan(int $userId, int $parkingId, int $entryId): array
    {
        // 1. Validate Reader (ParkingEntry)
        $entry = ParkingEntry::where('parking_entry_id', $entryId)
            ->where('parking_id', $parkingId)
            ->where('is_active', true)
            ->first();

        if (!$entry) {
            return ['ok' => false, 'code' => 422, 'error' => 'El lector no pertenece a este estacionamiento o está inactivo.'];
        }

        // 2. Check if user has an ACTIVE scan (is already inside)
        $activeScan = ActiveUserQrScan::where('user_id', $userId)->first();
        $now = Carbon::now();

        // CASE A: ENTRY (No active record) 
        if (!$activeScan) {
            if (!$entry->is_entry) {
                return ['ok' => false, 'code' => 403, 'error' => 'Acceso NO permitido: debe registrarse en un lector de entrada.'];
            }

            $scan = ActiveUserQrScan::create([
                'parking_entry_id' => $entry->parking_entry_id,
                'user_id' => $userId,
                'scan_time' => $now,
            ]);

            return [
                'ok' => true,
                'data' => [
                    'action' => 'entry',
                    'code' => $userId,
                    'parking_id' => $parkingId,
                    'entry_id' => $entry->parking_entry_id,
                    'scan' => [
                        'id' => $scan->active_user_qr_scan_id,
                        'scan_time' => $scan->scan_time->toDateTimeString(),
                    ],
                ]
            ];
        }

        // Case B: EXIT (User has active record)

        // Validate that the current reader is an EXIT reader
        if ($entry->is_entry) {
            return ['ok' => false, 'code' => 403, 'error' => 'Salida NO permitida en un lector de entrada.'];
        }

        // Validate that exit is in the SAME parking lot as entry
        $originalEntry = $activeScan->parkingEntry;

        if (!$originalEntry) {
            // Fallback query if relationship is not loaded/null
            $originalEntry = ParkingEntry::find($activeScan->parking_entry_id);
        }

        if (!$originalEntry || $entry->parking_id !== $originalEntry->parking_id) {
            return ['ok' => false, 'code' => 403, 'error' => 'Salida NO permitida: debe salir por un lector del mismo estacionamiento donde ingresó.'];
        }

        // Calculate duration
        $stayDurationSeconds = $activeScan->scan_time->diffInSeconds($now);

        $activeScan->delete();

        return [
            'ok' => true,
            'data' => [
                'action' => 'exit',
                'code' => $userId,
                'parking_id' => $parkingId,
                'entry_id' => $entry->parking_entry_id,
                'scan' => [
                    'id' => $activeScan->active_user_qr_scan_id,
                    'first_scan_time' => $activeScan->scan_time->toDateTimeString(),
                    'last_scan_time' => $now->toDateTimeString(),
                    'stay_duration_seconds' => $stayDurationSeconds,
                ],
            ]
        ];
    }
}

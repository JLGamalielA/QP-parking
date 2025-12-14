<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: QrScanService.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Service handling QR scan logic (Entry/Exit determination and execution) |
 */

namespace App\Services\Scanner;

use App\Models\ActiveUserQrScan;
use App\Models\ParkingEntry;
use Illuminate\Support\Facades\DB;
use Exception;

class QrScanService
{
    /**
     * Process a QR scan event.
     * Determines if it's an Entry or Exit and executes the corresponding logic.
     *
     * @param array $data
     * @return array Response structure for JSON output
     * @throws Exception
     */
    public function processScan(array $data): array
    {
        $userId = (int) $data['code'];
        $parkingId = (int) $data['parking_id'];
        $entryId = (int) $data['entry_id'];

        // 1. Validate Scanner State
        $currentEntry = ParkingEntry::where('parking_entry_id', $entryId)
            ->where('parking_id', $parkingId)
            ->where('is_active', true)
            ->first();

        if (!$currentEntry) {
            throw new Exception('El lector no pertenece a este estacionamiento o está inactivo.', 422);
        }

        // 2. Check for Active Session (User already inside?)
        $activeScan = ActiveUserQrScan::where('user_id', $userId)->first();

        if ($activeScan) {
            return $this->handleExit($activeScan, $currentEntry);
        } else {
            return $this->handleEntry($userId, $currentEntry);
        }
    }

    /**
     * Handle User Entry Logic.
     */
    protected function handleEntry(int $userId, ParkingEntry $entry): array
    {
        // Validation: Cannot enter through an Exit scanner
        if (!$entry->is_entry) {
            throw new Exception('Acceso DENEGADO: Debe registrarse en un lector de ENTRADA.', 403);
        }

        $scan = ActiveUserQrScan::create([
            'parking_entry_id' => $entry->parking_entry_id,
            'user_id' => $userId,
            'scan_time' => now(),
        ]);

        return [
            'status' => 'success',
            'action' => 'entry',
            'message' => 'Entrada registrada correctamente.',
            'data' => [
                'user_id' => $userId,
                'scan_time' => $scan->scan_time->toDateTimeString(),
            ]
        ];
    }

    /**
     * Handle User Exit Logic.
     */
    protected function handleExit(ActiveUserQrScan $activeScan, ParkingEntry $exitEntry): array
    {
        // Validation: Cannot exit through an Entry scanner
        if ($exitEntry->is_entry) {
            throw new Exception('Salida DENEGADA: Debe registrarse en un lector de SALIDA.', 403);
        }

        // Validation: Must exit from the same parking lot
        // We load the original entry relation to check the parking ID
        $originalEntry = $activeScan->parkingEntry;

        if ($originalEntry->parking_id !== $exitEntry->parking_id) {
            throw new Exception('Salida DENEGADA: Debe salir por el mismo estacionamiento donde ingresó.', 403);
        }

        return DB::transaction(function () use ($activeScan, $exitEntry) {
            $now = now();
            $duration = $activeScan->scan_time->diffInSeconds($now);


            // Remove active status
            $activeScan->delete();

            return [
                'status' => 'success',
                'action' => 'exit',
                'message' => "Salida registrada.\n Duración: " . gmdate('H:i:s', $duration),
                'data' => [
                    'user_id' => $activeScan->user_id,
                    'duration_seconds' => $duration,
                    'exit_time' => $now->toDateTimeString(),
                ]
            ];
        });
    }
}

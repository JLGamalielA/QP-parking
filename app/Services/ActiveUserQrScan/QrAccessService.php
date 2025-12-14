<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: QrAccessService.php
 * Created on: 26/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 26/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Service to handle QR scanning logic (Entry/Exit, validation, and transaction creation) |
 * 
 */

namespace App\Services\ActiveUserQrScan;

use App\Models\ActiveUserQrScan;
use App\Models\Parking;
use App\Models\ParkingEntry;
use App\Models\ParkingTransaction;
use App\Models\SpecialParkingUser;
use App\Models\User;
use App\Models\UserExitQrCode;
use App\Models\UserQrScanHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class QrAccessService
{
    /**
     * Process a QR scan request.
     *
     * @param int $userId
     * @param int $parkingId
     * @param int $entryId
     * @return array Result with 'ok', 'code', 'message' and 'data'
     */
    public function processScan(string $scanCode, int $parkingId, int $entryId): array
    {
        // Validate Reader (ParkingEntry) ownership and status
        $entry = ParkingEntry::where('parking_entry_id', $entryId)
            ->where('parking_id', $parkingId)
            ->where('is_active', true)
            ->first();

        if (!$entry) {
            return ['ok' => false, 'code' => 422, 'error' => 'El lector no pertenece a este estacionamiento o está inactivo.'];
        }

        $user = null;
        if (is_numeric($scanCode)) {
            $user = User::find((int)$scanCode);
        }

        if ($user) {
            $activeScan = ActiveUserQrScan::where('user_id', $user->user_id)->first();
            $now = Carbon::now();

            if (!$activeScan) {
                return $this->handleEntry($entry, $user->user_id, $now);
            }
            return $this->handleExit($activeScan, $entry, $user->user_id, $now);
        }

        $exitToken = UserExitQrCode::where('value', $scanCode)
            ->where('parking_id', $parkingId)
            ->first();

        if ($exitToken) {
            return $this->handleExitToken($exitToken, $entry);
        }

        return [
            'ok' => false,
            'code' => 404,
            'error' => 'El código escaneado no es válido.'
        ];
    }

    private function handleEntry(ParkingEntry $entry, int $userId, Carbon $now): array
    {
        // Validation: Attempting to enter through an exit reader
        if (!$entry->is_entry) {
            return ['ok' => false, 'code' => 403, 'error' => 'Acceso NO permitido: debe registrarse en un lector de entrada.'];
        }

        // Create active record
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
                'parking_id' => $entry->parking_id,
                'entry_id' => $entry->parking_entry_id,
                'scan_time' => $scan->scan_time->toDateTimeString(),
            ]
        ];
    }

    /**
     * Logic to process an exit and finalize transaction.
     */
    private function handleExit(ActiveUserQrScan $activeScan, ParkingEntry $currentEntry, int $userId, Carbon $now): array
    {
        // Validation: Attempting to exit through an entry reader
        if ($currentEntry->is_entry) {
            return ['ok' => false, 'code' => 403, 'error' => 'Salida NO permitida en un lector de entrada.'];
        }

        // Validation: User mismatch security check
        if ((int) $activeScan->user_id !== $userId) {
            return ['ok' => false, 'code' => 403, 'error' => 'El registro activo no corresponde a este usuario.'];
        }

        // Validation: Ensure exit is from the same parking lot
        $originalEntry = $activeScan->parkingEntry;
        if (!$originalEntry) {
            $originalEntry = ParkingEntry::find($activeScan->parking_entry_id);
        }

        if (!$originalEntry || $currentEntry->parking_id !== $originalEntry->parking_id) {
            return ['ok' => false, 'code' => 403, 'error' => 'Salida NO permitida: debe salir por un lector del mismo estacionamiento donde ingresó.'];
        }

        // Calculations
        $entryTime = Carbon::parse($activeScan->scan_time);
        $stayDurationSeconds = $entryTime->diffInSeconds($now);
        $amount = $this->calculateUserAmount($currentEntry->parking_id, $userId, $stayDurationSeconds);
        $user = User::find($userId);

        // Verify sufficient credit
        if ($user && $amount > $user->credit) {
            return [
                'ok' => false,
                'code' => 402,
                'error' => "Error: El monto a pagar: {$amount} es mayor al credito disponible del usuario {$user->credit}."
            ];
        }

        // Atomic Transaction: Create Transaction + History, Delete Active
        return DB::transaction(
            function () use ($activeScan, $currentEntry, $originalEntry, $userId, $stayDurationSeconds, $now, $amount, $user) {
                $user->credit -= $amount;
                $user->save();
                $transaction = ParkingTransaction::create([
                    'parking_id' => $currentEntry->parking_id,
                    'user_id' => $userId,
                    'amount_paid' => $amount,
                ]);

                // 3. Create Historical Log Record
                UserQrScanHistory::create([
                    'parking_entry' => $originalEntry->parking_entry_id,
                    'parking_exit' => $currentEntry->parking_entry_id,
                    'user_id' => $userId,
                    'first_scan_time' => $activeScan->scan_time,
                    'last_scan_time' => $now,
                    'stay_duration_seconds' => $stayDurationSeconds,
                    'parking_transaction_id' => $transaction->parking_transaction_id,
                ]);

                // 4. Remove from Active Scans (User is now out)
                $activeScan->delete();

                return [
                    'ok' => true,
                    'data' => [
                        'action' => 'exit',
                        'code' => $userId,
                        'exit_time'  => $now->format('H:i:s'),
                        'amount_paid' => number_format($amount, 2),
                        'new_credit'  => number_format($user->credit, 2),
                        'duration_seconds' => $stayDurationSeconds,
                        'transaction_id' => $transaction->parking_transaction_id
                    ]
                ];
            }
        );
    }


    /**
     * Handle logic for Special Exit Tokens.
     * Deletes the token and allows exit without payment calculation.
     */
    private function handleExitToken(UserExitQrCode $token, ParkingEntry $entry): array
    {
        if ($entry->is_entry) {
            return ['ok' => false, 'code' => 403, 'error' => 'Este pase de salida solo es válido en una terminal de salida.'];
        }
        // Execute Exit Logic (No transaction, No history)
        try {
            $token->delete();
            return [
                'ok' => true,
                'data' => [
                    'action' => 'exitToken',
                    'message' => 'Salida registrada correctamente.',
                    'type' => 'pass'
                ]
            ];
        } catch (Exception $e) {
            return [
                'ok' => false,
                'code' => 500,
                'error' => 'Error al procesar el pase de salida.'
            ];
        }
    }


    private function calculateUserAmount(int $parkingId, int $userId, int $seconds): float
    {
        $parking = Parking::where('parking_id', $parkingId)->first();
        $period = 0;
        $commission = 0.0;
        switch ($parking->type) {
            case 'hour':
                $period = 3600;
                $commission = $parking->price_per_hour;
                break;
            case 'static':
                $period = -1;
                $commission = $parking->fixed_price;
                break;
            default:
                $period = -1;
                $commission = $parking->fixed_price;
                break;
        }

        $specialParkingUser = SpecialParkingUser::where('parking_id', $parkingId)
            ->where('user_id', $userId)
            ->first();

        if ($specialParkingUser) {
            $period = $specialParkingUser->specialParkingRole->special_commission_period;
            $commission = $specialParkingUser->specialParkingRole->special_commission_value;
        }

        return $this->calculateAmount(
            $period,
            $commission,
            $seconds
        );
    }


    /**
     * Calculate amount paid based on parking rules.
     */
    private function calculateAmount(int $period, float $value, int $seconds): float
    {
        if ($period === -1) {
            return $value;
        }
        if ($seconds <= $period) {
            return $value;
        }
        $units = ceil($seconds / $period);
        return round($units * $value, 2);
    }

    /**
     * Retrieve paginated active scans for a specific parking, optionally filtered by search term.
     *
     * @param int $parkingId
     * @param string|null $search
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getActiveScans(int $parkingId, ?string $search, int $perPage): LengthAwarePaginator
    {
        // 1. Get Entry IDs belonging to this parking
        $entryIds = ParkingEntry::where('parking_id', $parkingId)
            ->pluck('parking_entry_id');

        // 2. Build the query
        $query = ActiveUserQrScan::whereIn('parking_entry_id', $entryIds)
            ->with(['user', 'parkingEntry'])
            ->orderBy('active_user_qr_scan_id', 'desc');

        // 3. Apply Search Filter if present
        if ($search) {
            $query->whereHas('user', function (Builder $q) use ($search) {
                // Remove spaces for searching if your DB stores raw numbers
                $sanitizedSearch = str_replace(' ', '', $search);
                $q->where('phone_number', 'like', "%{$sanitizedSearch}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // 4. Return paginated result
        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Force an exit administratively (Manual Release).
     * Mimics the exit logic but without a physical exit reader validation.
     *
     * @param int $activeScanId
     * @return array Result with 'ok', 'message'
     */
    public function forceExit(int $activeScanId): array
    {
        try {
            $activeScan = ActiveUserQrScan::find($activeScanId);

            if (!$activeScan) {
                return [
                    'ok' => false,
                    'error' => 'El registro de entrada ya no existe o fue procesado.'
                ];
            }
            $now = Carbon::now();

            // We assume the relationship 'parkingEntry.parking' exists
            $parkingEntry = $activeScan->parkingEntry;
            if (!$parkingEntry) {
                // Fallback if relation is missing
                $parkingEntry = ParkingEntry::find($activeScan->parking_entry_id);
            }
            if (!$parkingEntry) {
                return [
                    'ok' => false,
                    'error' => 'Error crítico: No se encontró el lector de entrada original asociado.'
                ];
            }

            $parking = $parkingEntry->parking;
            // Calculate duration
            $entryTime = Carbon::parse($activeScan->scan_time);
            $stayDurationSeconds = $entryTime->diffInSeconds($now);
            // Execute atomic transaction
            return DB::transaction(function () use ($activeScan, $parkingEntry, $parking, $stayDurationSeconds, $now) {
                // 1. Calculate Amount
                $amount = $this->calculateUserAmount($parking->parking_id, $activeScan->user->user_id, $stayDurationSeconds);

                // 2. Create Transaction
                $transaction = ParkingTransaction::create([
                    'parking_id' => $parking->parking_id,
                    'user_id' => $activeScan->user_id,
                    'amount_paid' => $amount,
                ]);

                // 3. Create History
                UserQrScanHistory::create([
                    'parking_entry' => $activeScan->parking_entry_id,
                    'parking_exit' => $activeScan->parking_entry_id,
                    'user_id' => $activeScan->user_id,
                    'first_scan_time' => $activeScan->scan_time,
                    'last_scan_time' => $now,
                    'stay_duration_seconds' => $stayDurationSeconds,
                    'parking_transaction_id' => $transaction->parking_transaction_id,
                ]);

                $qrValue = $this->createExitQrRecord($activeScan->user_id, $parking->parking_id);

                // 4. Delete Active Scan
                $activeScan->delete();

                return [
                    'ok' => true,
                    'value' => $qrValue,
                    'amount'  => $amount,
                    'message' => "Salida registrada manualmente.\n Duración: " . gmdate('H:i:s', $stayDurationSeconds)
                ];
            });
        } catch (\Exception $e) {
            // Log the exception in production
            return [
                'ok' => false,
                'error' => 'Ocurrió un error al intentar liberar la entrada. Por favor intente más tarde.'
            ];
        }
    }

    /**
     * Helper method to record the exit QR token.
     * Encapsulates the creation logic for user_exit_qr_codes table.
     * @param int $userId
     * @param int $parkingId
     * @return string The generated QR value
     */
    private function createExitQrRecord(int $userId, int $parkingId): string
    {
        $qrValue = "ESP" . $userId;

        UserExitQrCode::create([
            'user_id' => $userId,
            'parking_id' => $parkingId,
            'value' => $qrValue,
        ]);

        return $qrValue;
    }
}

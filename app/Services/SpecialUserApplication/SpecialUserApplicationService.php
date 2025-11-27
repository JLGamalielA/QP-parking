<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SpecialUserApplicationService.php
 * Created on: 26/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 26/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Service for managing special user parking applications logic.
 */

namespace App\Services\SpecialUserApplication;

use App\Models\Parking;
use App\Models\SpecialParkingUser;
use App\Models\SpecialUserParkingApplication;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class SpecialUserApplicationService
{
    /**
     * Get paginated applications for a parking with optional filters.
     *
     * @param int $parkingId
     * @param string|null $phoneFilter
     * @return LengthAwarePaginator
     */
    public function getApplications(int $parkingId, ?string $phoneFilter): LengthAwarePaginator
    {
        $query = SpecialUserParkingApplication::where('parking_id', $parkingId)
            ->with(['user', 'specialParkingRole'])
            ->orderBy('special_user_parking_application_id', 'desc');

        if ($phoneFilter) {
            $query->whereHas('user', function (Builder $q) use ($phoneFilter) {
                $sanitizedPhone = str_replace(' ', '', $phoneFilter);
                $q->where('phone_number', 'like', "%{$sanitizedPhone}%");
            });
        }

        return $query->paginate(10)->withQueryString();
    }

    /**
     * Approve an application by creating a SpecialParkingUser record.
     *
     * @param int $applicationId
     * @param string $endDate Y-m-d date string
     * @return array Result ['ok' => bool, 'error' => string|null]
     */
    public function approveApplication(int $applicationId, string $endDate): array
    {
        $application = SpecialUserParkingApplication::find($applicationId);

        if (!$application) {
            return ['ok' => false, 'error' => 'La solicitud no existe.'];
        }

        // Validate duplication (Business Logic)
        $exists = SpecialParkingUser::where('user_id', $application->user_id)
            ->where('parking_id', $application->parking_id)
            ->where('is_active', true) // Assuming only one active role per parking
            ->exists();

        if ($exists) {
            return ['ok' => false, 'error' => 'El usuario ya tiene un rol activo en este estacionamiento.'];
        }

        return DB::transaction(function () use ($application, $endDate) {
            // Create definitive record
            SpecialParkingUser::create([
                'user_id' => $application->user_id,
                'parking_id' => $application->parking_id,
                'special_parking_role_id' => $application->special_parking_role_id,
                'permission_start_date' => Carbon::now(),
                'permission_end_date' => Carbon::parse($endDate)->endOfDay(),
                'is_active' => true,
            ]);

            // Delete request
            $application->delete();

            return ['ok' => true];
        });
    }

    /**
     * Reject an application by deleting it.
     *
     * @param int $applicationId
     * @return bool
     */
    public function rejectApplication(int $applicationId): bool
    {
        $application = SpecialUserParkingApplication::find($applicationId);

        if (!$application) return false;

        return $application->delete();
    }
}

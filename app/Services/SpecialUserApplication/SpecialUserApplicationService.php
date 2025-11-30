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
use App\Models\SpecialUserApplication;
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
     * @param int $perPage Number of items per page (Default 10)
     * @return LengthAwarePaginator
     */
    public function getApplications(int $parkingId, ?string $phoneFilter, int $perPage): LengthAwarePaginator
    {
        $query = SpecialUserApplication::where('parking_id', $parkingId)
            ->with(['user', 'specialParkingRole'])
            ->orderBy('special_user_application_id', 'desc');

        if ($phoneFilter) {
            $query->whereHas('user', function (Builder $q) use ($phoneFilter) {
                $sanitizedPhone = str_replace(' ', '', $phoneFilter);
                $q->where('phone_number', 'like', "%{$sanitizedPhone}%");
            });
        }

        // Use dynamic pagination limit
        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Approve an application by creating a SpecialParkingUser record.
     *
     * @param int $applicationId
     * @return array Result ['ok' => bool, 'error' => string|null]
     */
    public function approveApplication(int $applicationId): array
    {
        $application = SpecialUserApplication::find($applicationId);

        if (!$application) {
            return ['ok' => false, 'error' => 'La solicitud no existe.'];
        }

        // Validate duplication
        $exists = SpecialParkingUser::where('user_id', $application->user_id)
            ->where('parking_id', $application->parking_id)
            ->exists();

        if ($exists) {
            return ['ok' => false, 'error' => 'El usuario ya tiene un rol activo en este estacionamiento.'];
        }

        return DB::transaction(function () use ($application) {
            // Create definitive record without end date or is_active
            SpecialParkingUser::create([
                'user_id' => $application->user_id,
                'parking_id' => $application->parking_id,
                'special_parking_role_id' => $application->special_parking_role_id,
                'permission_start_date' => Carbon::now(),
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
        $application = SpecialUserApplication::find($applicationId);

        if (!$application) return false;

        return $application->delete();
    }
}

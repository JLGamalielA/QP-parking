<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SpecialParkingUserService.php
 * Created on: 26/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 26/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Service for managing special parking users business logic. |
 * 
 *  - ID: 2 | Modified on: 26/11/2025 |
 *    Modified by: Daniel Yair Mendoza Alvarez |
 *    Description: Added update and delete methods with existence validation. |
 */

namespace App\Services\SpecialParkingUser;

use App\Models\SpecialParkingUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SpecialParkingUserService
{
    /**
     * Get paginated special users with optional role filter.
     *
     * @param int $parkingId
     * @param int|null $roleIdFilter
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getSpecialUsers(int $parkingId, ?int $roleIdFilter, int $perPage = 5): LengthAwarePaginator
    {
        $query = SpecialParkingUser::where('parking_id', $parkingId)
            ->with(['user', 'specialParkingRole'])
            ->orderBy('special_parking_user_id', 'desc');

        if ($roleIdFilter) {
            $query->where('special_parking_role_id', $roleIdFilter);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Update a special parking user.
     *
     * @param int $id
     * @param array $data
     * @return string Status ('success', 'not_found', 'error')
     */
    public function updateSpecialUser(int $id, array $data): string
    {
        try {
            $specialUser = SpecialParkingUser::find($id);

            if (!$specialUser) {
                return 'not_found';
            }

            $specialUser->update([
                'special_parking_role_id' => $data['special_parking_role_id'],
                'permission_end_date' => $data['permission_end_date'],
                // 'is_active' removed per requirement
            ]);

            return 'success';
        } catch (\Exception $e) {
            return 'error';
        }
    }

    /**
     * Delete a special parking user.
     *
     * @param int $id
     * @return string Status ('success', 'not_found', 'error')
     */
    public function deleteSpecialUser(int $id): string
    {
        try {
            $specialUser = SpecialParkingUser::find($id);

            if (!$specialUser) {
                return 'not_found';
            }

            $specialUser->delete();
            return 'success';
        } catch (\Exception $e) {
            return 'error';
        }
    }
}

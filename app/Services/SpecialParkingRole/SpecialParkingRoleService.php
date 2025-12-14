<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SpecialParkingRoleService.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Service for managing special parking role business logic |
 * 
 * - ID: 2 | Modified on: 24/11/2025 | 
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Added update and delete methods |
 * 
 */

namespace App\Services\SpecialParkingRole;

use App\Models\Parking;
use App\Models\SpecialParkingRole;
use Illuminate\Support\Facades\Auth;

class SpecialParkingRoleService
{
    /**
     * Creates a new special role linked to the authenticated user's parking.
     *
     * @param array $data Validated data from request.
     * @return SpecialParkingRole
     * @throws \Exception If user has no parking registered.
     */
    public function createRole(array $data): SpecialParkingRole
    {
        $parking = Parking::where('user_id', Auth::id())->firstOrFail();

        return SpecialParkingRole::create([
            'parking_id' => $parking->parking_id,
            'type' => $data['type'],
            'special_commission_period' => $data['special_commission_period'],
            'special_commission_value' => $data['special_commission_value'],
        ]);
    }

    /**
     * Updates an existing special role.
     *
     * @param SpecialParkingRole $role
     * @param array $data Validated data from request.
     * @return bool
     */
    public function updateRole(SpecialParkingRole $role, array $data): bool
    {
        return $role->update([
            'type' => $data['type'],
            'special_commission_period' => $data['special_commission_period'],
            'special_commission_value' => $data['special_commission_value'],
        ]);
    }

    /**
     * Attempts to delete a special role by its ID.
     *
     * @param int $id
     * @return stringStatus ('success', 'not_found', 'error')
     */
    public function deleteRoleById(int $id): string
    {
        $parking = Parking::where('user_id', Auth::id())->first();
        $role = SpecialParkingRole::where('special_parking_role_id', $id)
            ->where('parking_id', $parking->parking_id)
            ->first();
        try {
            if (!$role) {
                return 'not_found';
            }
            $role->delete();
            return 'success';
        } catch (\Exception $e) {
            // Log error if needed
            return 'error';
        }
    }

    /**
     * Retrieves a specific role by ID, ensuring it belongs to the user's parking.
     *
     * @param int $id
     * @return SpecialParkingRole|null
     */
    public function getRoleById(int $id): ?SpecialParkingRole
    {
        $parking = Parking::where('user_id', Auth::id())->first();

        if (!$parking) {
            return null;
        }
        return SpecialParkingRole::where('special_parking_role_id', $id)
            ->where('parking_id', $parking->parking_id)
            ->first();
    }
}

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
 * Modified by: Daniel Yair Mendoza Alvarez | 
 * Description: Service for managing special parking role business logic. |
 */

namespace App\Services;

use App\Models\SpecialParkingRole;
use App\Models\Parking;
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
}

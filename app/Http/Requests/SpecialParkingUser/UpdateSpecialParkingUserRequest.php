<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UpdateSpecialParkingUserRequest.php
 * Created on: 26/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 26/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Validation rules for updating a special parking user |
 * 
 */

namespace App\Http\Requests\SpecialParkingUser;

use App\Models\Parking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateSpecialParkingUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $parking = Parking::where('user_id', Auth::id())->first();
        $parkingId = $parking ? $parking->parking_id : null;

        return [
            'special_parking_role_id' => [
                'required',
                'integer',
                // Ensure the role belongs to the current admin's parking
                Rule::exists('special_parking_roles', 'special_parking_role_id')
                    ->where('parking_id', $parkingId),
            ]
        ];
    }

    /**
     * Get custom error messages for validation failures.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'special_parking_role_id.required' => 'El campo rol es obligatorio',
            'special_parking_role_id.exists' => 'El rol seleccionado no es válido o no pertenece a tu estacionamiento'
        ];
    }
}

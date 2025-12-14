<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: StoreSpecialParkingRoleRequest.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Validation rules for storing a special parking role. |
 */

namespace App\Http\Requests\SpecialParkingRole;

use App\Models\Parking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreSpecialParkingRoleRequest extends FormRequest
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
        // Get the current user's parking ID to validate uniqueness within scope
        $parking = Parking::where('user_id', Auth::id())->first();
        $parkingId = $parking ? $parking->parking_id : null;

        return [
            'type' => [
                'required',
                'string',
                'max:80',
                // Unique rule scoped to parking_id
                Rule::unique('special_parking_roles', 'type')->where('parking_id', $parkingId)
            ],
            'special_commission_period' => 'required|integer|in:3600,-1',
            'special_commission_value' => 'required|numeric|min:0|max:999.99|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'type.required' => 'El campo nombre es obligatorio',
            'type.unique' => 'El nombre ya está en uso en tu estacionamiento',
            'type.max' => 'El nombre no debe exceder 80 caracteres',

            'special_commission_period.required' => 'El campo periodo de comisión es obligatorio',

            'special_commission_value.required' => 'El campo valor de comisión es obligatorio',
            'special_commission_value.min' => 'El valor de comisión debe ser mayor o igual que 0',
            'special_commission_value.max' => 'El valor de comisión debe ser menor o igual que 999.99',
            'special_commission_value.regex' => 'El valor de comisión no tiene un formato válido (máximo 2 decimales).',
        ];
    }
}

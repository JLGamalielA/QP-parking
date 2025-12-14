<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UpdateSpecialParkingRoleRequest.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Validation rules for updating a special parking role |
 * 
 */

namespace App\Http\Requests\SpecialParkingRole;

use App\Models\Parking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateSpecialParkingRoleRequest extends FormRequest
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
        // Get the current parking ID to validate uniqueness within scope
        $parking = Parking::where('user_id', Auth::id())->first();
        $parkingId = $parking ? $parking->parking_id : null;

        // Get the ID of the role being updated from the route
        $roleId = $this->route('special_parking_role');

        return [
            'type' => [
                'required',
                'string',
                'min:4',
                'max:80',
                'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$/',
                // Unique rule scoped to parking_id, ignoring the current role ID
                Rule::unique('special_parking_roles', 'type')
                    ->where('parking_id', $parkingId)
                    ->ignore($roleId, 'special_parking_role_id')
            ],
            'special_commission_period' => 'required|integer|in:3600,-1',
            'special_commission_value' => 'required|numeric|min:0|max:999.99|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'type.required' => 'El campo nombre es obligatorio',
            'type.unique' => 'El nombre ya está en uso en tu estacionamiento',
            'type.max' => 'El nombre no debe exceder 80 caracteres',
            'type.min' => 'El nombre debe tener al menos 4 caracteres',
            'type.regex' => 'El nombre contiene caracteres no permitidos',

            'special_commission_period.required' => 'El campo periodo de comisión es obligatorio',
            'special_commission_period.in' => 'La opción seleccionada en periodo de comisión no es válida',

            'special_commission_value.required' => 'El campo valor de comisión es obligatorio',
            'special_commission_value.min' => 'El valor de comisión debe ser mayor o igual que 0',
            'special_commission_value.max' => 'El valor de comisión debe ser menor o igual que 999.99',
            'special_commission_value.regex' => 'El valor de comisión no tiene un formato válido (máximo 2 decimales).',
        ];
    }
}

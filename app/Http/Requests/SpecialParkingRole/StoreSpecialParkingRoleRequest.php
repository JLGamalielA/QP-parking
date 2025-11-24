<?php

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
                'max:150',
                // Unique rule scoped to parking_id
                Rule::unique('special_parking_roles', 'type')->where('parking_id', $parkingId)
            ],
            'special_commission_period' => 'required|integer|in:3600,86400',
            'special_commission_value' => 'required|numeric|min:0|max:9999.99|regex:/^\d+(\.\d{1,2})?$/',
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
            'type.required' => 'Por favor, ingresa el nombre del tipo de usuario.',
            'type.unique' => 'Ya existe un tipo de usuario con este nombre en tu estacionamiento.',
            'type.max' => 'El nombre es demasiado largo.',

            'special_commission_period.required' => 'Selecciona un periodo de comisión.',

            'special_commission_value.required' => 'Debes asignar un costo de comisión.',
            'special_commission_value.min' => 'El costo no puede ser negativo.',
            'special_commission_value.max' => 'El costo supera el límite permitido.',
            'special_commission_value.regex' => 'El formato del costo es inválido.',
        ];
    }
}

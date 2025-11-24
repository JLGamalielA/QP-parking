<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UpdateParkingRequest.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Validation rules and messages for updating a parking. |
 */

namespace App\Http\Requests\Parking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateParkingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // Get the current parking ID from the route parameter
        $parkingId = $this->route('parking')->parking_id;

        return [
            // General Information (with Unique Ignore)
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('parkings', 'name')->ignore($parkingId, 'parking_id')
            ],
            'address' => [
                'required',
                'string',
                'max:255',
                Rule::unique('parkings', 'address')->ignore($parkingId, 'parking_id')
            ],

            'commission_period' => 'required|integer|in:3600,86400',
            'commission_value' => 'required|numeric|min:0|max:9999.99|regex:/^\d+(\.\d{1,2})?$/',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',

            // Schedule Array Validation (Same as Store)
            'schedules' => 'required|array|size:7',
            'schedules.*.weekday' => 'required|integer|between:0,6',
            'schedules.*.is_open' => 'required|boolean',
            'schedules.*.opening_time' => 'nullable|date_format:H:i|required_if:schedules.*.is_open,1',
            'schedules.*.closing_time' => 'nullable|date_format:H:i|required_if:schedules.*.is_open,1|after:schedules.*.opening_time',
        ];
    }

    /**
     * Configure the validator instance.
     * (Same logic as Store: At least one day open).
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $schedules = $this->input('schedules', []);
            $hasOpenDay = collect($schedules)->contains('is_open', '1');

            if (!$hasOpenDay) {
                $validator->errors()->add('schedules', 'Debes seleccionar al menos un día de operación para el estacionamiento.');
            }
        });
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Por favor, ingresa el nombre del estacionamiento.',
            'name.unique' => 'Este nombre ya está registrado en otro estacionamiento.',
            'name.max' => 'El nombre es demasiado largo (máximo 100 caracteres).',

            'address.required' => 'Es necesario registrar la dirección del estacionamiento.',
            'address.max' => 'La dirección es demasiado larga (máximo 255 caracteres).',
            'address.unique' => 'Esta dirección ya se encuentra registrada.',

            'commission_period.required' => 'Selecciona un periodo de pago de la lista.',

            'commission_value.required' => 'Debes asignar un costo al estacionamiento.',
            'commission_value.min' => 'El costo debe ser un valor positivo (mayor o igual a 0).',
            'commission_value.max' => 'El costo supera el límite permitido ($9,999.99).',
            'commission_value.regex' => 'El formato del costo es inválido (usa hasta dos decimales).',

            'latitude.required' => 'Selecciona una ubicación en el mapa.',
            'latitude.between' => 'La ubicación seleccionada no es válida (latitud fuera de rango).',

            'longitude.required' => 'Selecciona una ubicación en el mapa.',
            'longitude.between' => 'La ubicación seleccionada no es válida (longitud fuera de rango).',

            // Schedule Messages
            'schedules.*.opening_time.required_if' => 'La hora de apertura es obligatoria.',
            'schedules.*.closing_time.required_if' => 'La hora de cierre es obligatoria.',
            'schedules.*.closing_time.after' => 'La hora de cierre debe ser posterior a la hora de apertura',
        ];
    }
}

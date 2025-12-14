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
                'max:80',
                Rule::unique('parkings', 'name')->ignore($parkingId, 'parking_id')
            ],

            'type' => [
                'required',
                'string',
                Rule::in(['hour', 'static', 'mixed'])
            ],
            'price_per_hour' => [
                'nullable',
                'required_if:type,hour,mixed',
                'numeric',
                'min:1',
                'max:999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'fixed_price' => [
                'nullable',
                'required_if:type,static,mixed',
                'numeric',
                'min:0',
                'max:999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],

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
            'name.required' => 'El campo nombre es obligatorio',
            'name.unique' => 'El nombre ya está en uso',
            'name.max' => 'El nombre no debe exceder 80 caracteres',

            'type.required' => 'El campo tipo de tarifa es obligatorio',
            'type.in' => 'La opción seleccionada en tipo de tarifa no es válida',

            'price_per_hour.required_if' => 'El campo precio por hora es obligatorio',
            'price_per_hour.min' => 'El precio por hora debe ser mayor o igual a 1',
            'price_per_hour.max' => 'El precio por hora debe ser menor o igual que 999.99',
            'price_per_hour.regex' => 'El precio por hora no tiene un formato válido (máximo 2 decimales).',

            'fixed_price.required_if' => 'El campo precio tarifa fija es obligatorio',
            'fixed_price.min' => 'El precio por tarifa fija debe ser mayor o igual a 0.',
            'fixed_price.max' => 'El precio por tarifa fija debe ser menor o igual que 999.99',
            'fixed_price.regex' => 'El precio por tarifa fija no tiene un formato válido (máximo 2 decimales).',

            'latitude.required' => 'El campo latitud es obligatorio',
            'latitude.between' => 'La ubicación seleccionada no es válida (latitud fuera de rango).',

            'longitude.required' => 'El campo longitud es obligatorio',
            'longitude.between' => 'La ubicación seleccionada no es válida (longitud fuera de rango).',

            // Schedule Messages
            'schedules.*.opening_time.required_if' => 'El campo apertura es obligatorio',
            'schedules.*.closing_time.required_if' => 'El campo cierre es obligatorio',
            'schedules.*.closing_time.after' => 'La hora de cierre debe ser posterior a la hora de apertura',
        ];
    }
}

<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: StoreParkingRequest.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Validation rules and messages for storing a new parking. |
 */

namespace App\Http\Requests\Parking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Validator;

class StoreParkingRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:100|unique:parkings,name',
            'address' => 'required|string|max:255|unique:parkings,address',
            'commission_period' => 'required|integer',
            'commission_value' => 'required|numeric|min:0|max:9999.99|regex:/^\d+(\.\d{1,2})?$/',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            // Schedule Array Validation
            'schedules' => 'required|array|size:7',
            'schedules.*.weekday' => 'required|integer|between:0,6',
            'schedules.*.is_open' => 'required|boolean',
            // Rule: Time is required ONLY if is_open is true (1)
            'schedules.*.opening_time' => 'nullable|date_format:H:i|required_if:schedules.*.is_open,1',
            'schedules.*.closing_time' => 'nullable|date_format:H:i|required_if:schedules.*.is_open,1|after:schedules.*.opening_time',
        ];
    }

    /**
     * Configure the validator instance.
     * Used here to implement complex logic like "At least one day open".
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $schedules = $this->input('schedules', []);

            // Filter the array to find open days
            // Using Laravel Collection method 'contains' or native array_filter
            $hasOpenDay = collect($schedules)->contains('is_open', '1');

            if (!$hasOpenDay) {
                // Add a global error to the 'schedules' field
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
            'name.required' => 'El campo nombre es obligatorio.',
            'name.unique' => 'Este nombre ya está registrado en otro estacionamiento.',
            'name.max' => 'El nombre es demasiado largo (máximo 100 caracteres).',

            'address.required' => 'El campo dirección es obligatorio.',
            'address.max' => 'La dirección es demasiado larga (máximo 255 caracteres).',
            'address.unique' => 'Esta dirección ya se encuentra registrada.',

            'commission_period.required' => 'El campo periodo de pago es obligatorio.',

            'commission_value.required' => 'El campo costo es obligatorio.',
            'commission_value.min' => 'El costo debe ser un valor positivo (mayor o igual a 0).',
            'commission_value.max' => 'El costo supera el límite permitido ($9,999.99).',
            'commission_value.regex' => 'El formato del costo es inválido (usa hasta dos decimales).',

            'latitude.required' => 'El campo latitud es obligatorio.',
            'latitude.between' => 'La ubicación seleccionada no es válida (latitud fuera de rango).',

            'longitude.required' => 'El campo longitud es obligatorio.',
            'longitude.between' => 'La ubicación seleccionada no es válida (longitud fuera de rango).',

            // Schedule Messages
            'schedules.*.opening_time.required_if' => 'El campo apertura es obligatorio.',
            'schedules.*.closing_time.required_if' => 'El campo cierre es obligatorio.',
            'schedules.*.closing_time.after' => 'La hora de cierre debe ser posterior a la hora de apertura',
        ];
    }
}

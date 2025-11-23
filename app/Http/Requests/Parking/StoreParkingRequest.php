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
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Validation rules and messages for storing a new parking. |
 */

namespace App\Http\Requests\Parking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

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
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del estacionamiento es obligatorio.',
            'address.required' => 'La dirección del estacionamiento es obligatoria.',
            'commission_period.required' => 'El período de pago es obligatorio.',
            'commission_value.required' => 'El costo es obligatorio.',
            'name.unique' => 'Ya existe un estacionamiento con este nombre.',
            'address.unique' => 'Ya existe un estacionamiento con esta dirección.',
        ];
    }

    /**
     * Configure the validator instance.
     * Custom logic validation hooks (Time constraints).
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            try {
                $start = Carbon::createFromFormat('H:i', $this->opening_time);
                $end = Carbon::createFromFormat('H:i', $this->closing_time);

                if ($start->gte($end)) {
                    $validator->errors()->add('opening_time', 'La hora de apertura no puede ser posterior ni igual a la hora de cierre.');
                }

                if ($start->diffInMinutes($end) < 60) {
                    $validator->errors()->add('closing_time', 'El horario debe tener una duración mínima de una hora.');
                }
            } catch (\Exception $e) {
                // Date format errors are handled by 'date_format' rule
            }
        });
    }
}

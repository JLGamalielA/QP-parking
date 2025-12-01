<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UpdateParkingEntryRequest.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Validation rules for updating a parking entry scanner. |
 */

namespace App\Http\Requests\ParkingEntry;

use App\Models\Parking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateParkingEntryRequest extends FormRequest
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
        // Retrieve the route parameter
        $routeEntry = $this->route('parking_entry');
        // Fix: Check if it's an object (Model Binding) or a raw ID (String/Int)
        $entryId = is_object($routeEntry) ? $routeEntry->parking_entry_id : $routeEntry;

        return [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('parking_entries', 'name')
                    ->where('parking_id', $parkingId)
                    ->ignore($entryId, 'parking_entry_id')
            ],
            'is_entry' => 'required|boolean',
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
            'name.required' => 'El campo nombre es obligatorio',
            'name.unique' => 'Ya existe un lector con este nombre.',
            'is_entry.required' => 'El campo tipo de lector es obligatorio',
        ];
    }
}

<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: StoreManualAccessRequest.php
 * Created on: 04/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 04/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Validation rules and messages for storing manual access |
 * 
 */


namespace App\Http\Requests\ManualAccess;

use Illuminate\Foundation\Http\FormRequest;

class StoreManualAccessRequest extends FormRequest
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
        return [
            'parking_entry_id' => 'required|exists:parking_entries,parking_entry_id',
            'phone_number'     => 'required|string|numeric|exists:users,phone_number',
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone_number.required' => 'El campo número de teléfono es obligatorio',
            'phone_number.exists'   => 'El número de teléfono no está asociado a ningún usuario registrado',
            'phone_number.numeric'  => 'El número de teléfono solo debe contener números',
            'parking_entry_id.required' => 'El campo lector es obligatorio',
            'parking_entry_id.exists' => 'El lector seleccionado no es válido',
        ];
    }
}

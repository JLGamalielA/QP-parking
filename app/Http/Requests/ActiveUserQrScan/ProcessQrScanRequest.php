<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ProcessQrScanRequest.php
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 | 
 *   Modified by: Daniel Yair Mendoza Alvarez | 
 *   Description: Validation for QR scan processing via Web Serial API. |
 */

namespace App\Http\Requests\ActiveUserQrScan;

use Illuminate\Foundation\Http\FormRequest;

class ProcessQrScanRequest extends FormRequest
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
            // 'code' corresponds to the user_id scanned from the QR
            'code'       => 'required|integer|exists:users,user_id',
            'parking_id' => 'required|integer|exists:parkings,parking_id',
            'entry_id'   => 'required|integer|exists:parking_entries,parking_entry_id',
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
            'code.exists' => 'El código QR no corresponde a un usuario válido.',
            'entry_id.exists' => 'El lector especificado no es válido.',
            'code.integer' => 'El código QR no es válido.',
        ];
    }
}

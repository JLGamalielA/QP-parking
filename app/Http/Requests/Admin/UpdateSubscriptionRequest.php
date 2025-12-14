<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UpdateSubscriptionRequest.php
 * Created on: 04/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 04/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Validation rules and messages for updating a subscription. |
 */


namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubscriptionRequest extends FormRequest
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
        $subscriptionId = $this->route('subscription');
        return [
            'name'  => [
                'required',
                'string',
                'max:15',
                Rule::unique('subscriptions', 'name')->ignore($subscriptionId, 'subscription_id')
            ],
            'price' => 'required|numeric|min:0|max:1000.00|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    /**
     * Get custom messages for validator errors.
     * Adheres to Manual Section 8.2.12 Microcopy standards.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'  => 'El campo nombre es obligatorio',
            'name.max'       => 'El nombre no debe exceder los 15 caracteres',
            'name.unique'    => 'El nombre ya está en uso',
            'price.required' => 'El campo precio es obligatorio',
            'price.numeric'  => 'El precio solo debe contener números',
            'price.max'      => 'El precio debe ser menor o igual que 1000',
            'price.regex'    => 'El precio no tiene un formato válido',
            'price.min'      => 'El precio debe ser mayor o igual que 0',
        ];
    }
}

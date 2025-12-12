<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: Payment.php
 * Created on: 11/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 11/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Payment component for processing parking plan subscriptions. |
 */

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Subscription;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Payment extends Component
{
    public Subscription $subscription;

    public $cardName = '';
    public $cardNumber = '';
    public $cardExpiryMonth = '';
    public $cardExpiryYear = '';
    public $cardCvc = '';


    /**
     * Mount the component with the given subscription
     */
    public function mount(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Validation rules
     */
    protected function rules()
    {
        return [
            'cardName' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'cardNumber' => ['required', 'numeric', 'digits:16'],
            'cardExpiryMonth' => ['required', 'numeric', 'between:1,12', 'digits_between:1,2'],
            'cardExpiryYear' => ['required', 'numeric', 'digits:2', 'min:' . date('y')],
            'cardCvc' => ['required', 'numeric', 'digits:3'],
        ];
    }

    /**
     * Custom error messages
     */
    protected function messages()
    {
        return [
            'cardName.required' => 'El campo nombre en la tarjeta es obligatorio',
            'cardName.min' => 'El nombre en la tarjeta debe tener al menos 3 caracteres.',
            'cardName.regex' => 'El nombre en la tarjeta contiene caracteres inválidos.',

            'cardNumber.required' => 'El campo número de tarjeta es obligatorio',
            'cardNumber.numeric' => 'El número de tarjeta contiene caracteres inválidos.',
            'cardNumber.digits' => 'El número de tarjeta debe tener 16 dígitos.',

            'cardExpiryMonth.required' => 'El campo mes es obligatorio',
            'cardExpiryMonth.between' => 'El mes debe ser entre 01 y 12.',

            'cardExpiryYear.required' => 'El campo año es obligatorio',
            'cardExpiryYear.digits' => 'Ingresa los últimos 2 dígitos del año.',
            'cardExpiryYear.min' => 'La tarjeta está vencida (año anterior).',

            'cardCvc.required' => 'El campo CVC es obligatorio',
            'cardCvc.digits' => 'El CVC debe tener 3 dígitos.',
        ];
    }

    /**
     * Real-time validation on updated fields
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Process the payment
     */
    public function processPayment()
    {
        $this->validate();

        $expiresAt = \Carbon\Carbon::createFromDate(
            '20' . $this->cardExpiryYear,
            $this->cardExpiryMonth,
            1
        )->endOfMonth();

        if ($expiresAt->isPast()) {
            $this->addError('cardExpiryMonth', 'La tarjeta ha expirado.');
            return;
        }

        sleep(1);
        UserSubscription::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'subscription_id' => $this->subscription->subscription_id,
                'start_date'      => Carbon::now(),
                'end_date'        => Carbon::now()->addMonth(),
                'is_active'       => true,
            ]
        );

        return redirect()->route('qpk.dashboard.index')->with('swal', [
            'icon' => 'success',
            'title' => '¡Pago Exitoso!',
            'text' => 'Tu suscripción ha sido activada correctamente.'
        ]);
    }

    /**
     * Render the component view
     */
    public function render()
    {
        return view('modules.parking_admin.parking_plan.checkout')
            ->extends('layouts.inactive')
            ->section('content');
    }
}

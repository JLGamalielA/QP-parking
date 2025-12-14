<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: Register.php
 * Created on: 15/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 15/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Initial creation of the component based on Volt template standard |
 *
 * - ID: 2 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Adaptation of fields to QPK schema (split names, dates) and dynamic routing config |
 * 
 */

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Rule;

class Register extends Component
{
    public int $currentStep = 1;

    // Personal Information
    #[Rule('required|string|min:3|max:30|regex:/^[\pL\s]+$/u')]
    public $firstName = '';
    #[Rule('required|string|min:3|max:30|regex:/^[\pL\s]+$/u')]
    public $lastName = '';

    // Contact Information
    #[Rule('required|digits:10')]
    public $phoneNumber = '';

    #[Rule('required|email:rfc,dns|unique:users,email')]
    public $email = '';

    // Security
    #[Rule('required|min:8')]
    public $password = '';

    #[Rule('required|same:password')]
    public $passwordConfirmation = '';

    // Terms of Service (Standard in Volt Template UI)
    #[Rule('accepted')]
    public bool $terms = false;

    private array $validationRules = [
        1 => [
            'firstName' => 'required|string|min:3|max:30|regex:/^[\pL\s]+$/u',
            'lastName' => 'required|string|min:3|max:30|regex:/^[\pL\s]+$/u',
            'phoneNumber' => 'required|digits:10|unique:users,phone_number',
        ],
        2 => [
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:8',
            'passwordConfirmation' => 'required|same:password',
        ],
        3 => [
            'terms' => 'required|accepted',
        ],
    ];

    /**
     * Mount lifecycle hook.
     * Redirects authenticated users to the dashboard to prevent re-registration.
     */
    public function mount()
    {
        if (auth('web')->user()) {
            return redirect()->intended(route(config('proj.route_name_prefix', 'proj') . '.dashboard.index'));
        }
    }

    /**
     * Proceed to the next step after validating current step fields.
     *
     * @return void
     */
    public function nextStep()
    {
        $rules = $this->validationRules[$this->currentStep];

        $this->validate($rules);

        if ($this->currentStep < 3) {
            $this->currentStep++;
        }
    }

    /**
     * Return to the previous step.
     *
     * @return void
     */
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    /**
     * Real-time validation for email.
     * Provides immediate feedback if the email is already taken.
     */
    public function updatedEmail()
    {
        $this->validateOnly('email');
    }

    /**
     * Handle the registration process.
     */
    public function register()
    {
        $this->validate();

        // Create the user with mass assignment mapping
        $user = User::create([
            'first_name' => $this->firstName,
            'last_name'  => $this->lastName,
            'phone_number' => $this->phoneNumber,
            'email'      => $this->email,
            'password'   => Hash::make($this->password),
            'credit'     => 0, 
            'platform'   => 'web', 
            'remember_token' => Str::random(10),
        ]);

        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.auth.login')
            ->with('swal', [
                'icon'  => 'success',
                'title' => '¡Registro Exitoso!',
                'text'  => 'Tu cuenta ha sido creada. Por favor, inicia sesión.',
            ]);
    }

    /**
     * Render the registration view.
     */
    public function render()
    {
        return view('modules.auth.register')->layout('layouts.guest');
    }

    /**
     * Define custom validation messages for fields.
     */
    public function messages(): array
    {
        return [
            'firstName.required' => 'El campo nombre es obligatorio',
            'firstName.min' => 'El nombre debe tener al menos :min caracteres.',
            'firstName.max' => 'El nombre no debe exceder de :max caracteres.',
            'firstName.regex' => 'El nombre solo puede contener letras y espacios.',
            'lastName.required' => 'El campo apellido es obligatorio',
            'lastName.min' => 'El apellido debe tener al menos :min caracteres.',
            'lastName.max' => 'El apellido no debe exceder de :max caracteres.',
            'lastName.regex' => 'El apellido solo puede contener letras y espacios.',
            'phoneNumber.required' => 'El campo teléfono es obligatorio',
            'phoneNumber.digits' => 'El teléfono debe tener exactamente :digits dígitos.',
            'phoneNumber.unique' => 'El teléfono ya está registrado en otra cuenta.',
            'email.required' => 'El campo correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'El correo electrónico ya está registrado en otra cuenta.',
            'password.required' => 'El campo contraseña es obligatorio',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'passwordConfirmation.required' => 'El campo confirmar contraseña es obligatorio',
            'passwordConfirmation.same' => 'El campo confirmar contraseña no coincide con la contraseña.',
            'terms.accepted' => 'Debe aceptar los términos y condiciones para continuar.',
        ];
    }

    /**
     * Real-time validation for terms acceptance.
     */
    public function updatedTerms()
    {
        $this->validateOnly('terms');
    }
}

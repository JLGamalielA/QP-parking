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
 * Description: Initial creation of the component based on Volt template standard. |
 *
 * - ID: 2 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Adaptation of fields to QPK schema (split names, dates) and dynamic routing config. |
 */

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;

class Register extends Component
{

    // Personal Information
    #[Rule('required|string|min:2|max:50')]
    public $first_name = '';

    #[Rule('required|string|min:2|max:50')]
    public $last_name = '';

    #[Rule('required|date|before:today')]
    public $birth_date = '';

    // Contact Information
    #[Rule('required|digits:10')]
    public $phone_number = '';

    #[Rule('required|email:rfc,dns|unique:users,email')]
    public $email = '';

    // Security
    #[Rule('required|min:8')]
    public $password = '';

    #[Rule('required|same:password')]
    public $passwordConfirmation = '';

    // Terms of Service (Standard in Volt Template UI)
    #[Rule('accepted')]
    public $agreement = false;


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
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'birth_date' => $this->birth_date,
            'phone_number' => $this->phone_number,
            'email'      => $this->email,
            'password'   => Hash::make($this->password),
            'credit'     => 0, // Explicit default value
            'remember_token' => Str::random(10),
        ]);

        auth()->login($user);

        return redirect()->intended(route(config('proj.route_name_prefix', 'proj') . '.dashboard'));
    }

    public function render()
    {
        return view('modules.auth.register')->layout('layouts.guest');
    }
}

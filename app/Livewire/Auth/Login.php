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
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Initial creation of the component based on Volt template standard. |
 *
 * - ID: 2 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Adaptation of fields to QPK schema (split names, dates) and dynamic routing config. |
 */

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;

class Login extends Component
{

    #[Rule('required|email:rfc,dns')]
    public $email = '';

    #[Rule('required|min:6')]
    public $password = '';

    public $remember_me = false;

    //This mounts the default credentials for the admin. Remove this section if you want to make it public.
    public function mount()
    {
        if (auth()->user()) {

            $user = auth()->user();
            $prefix = config('proj.route_name_prefix', 'proj');

            if ($user->platform !== 'web') {
                auth()->logout();
                return redirect()->route($prefix . '.auth.login');
            }

            if ($user->isGeneralAdmin()) {
                return redirect()->intended(route($prefix . '.admin-dashboard.index'));
            }

            if (!$user->subscription || !$user->subscription->is_active) {
                return redirect()->intended(route($prefix . '.parking-plans.index'));
            }

            return redirect()->intended(route($prefix . '.dashboard.index'));
        }
    }

    public function login()
    {
        $this->validate();

        if (!auth()->validate(['email' => $this->email, 'password' => $this->password])) {
            return $this->addError('email', trans('auth.failed'));
        }

        $user = User::where('email', $this->email)->first();

        if ($user->platform !== 'web') {
            $this->addError('email', 'Esta cuenta es inválida para la plataforma web.');
            return;
        }
        auth()->login($user, $this->remember_me);

        $prefix = config('proj.route_name_prefix', 'proj');

        if ($user->isGeneralAdmin()) {
            return redirect()->intended(route($prefix . '.admin-dashboard.index'));
        }

        if (!$user->subscription || !$user->subscription->is_active) {
            return redirect()->intended(route($prefix . '.parking-plans.index'));
        }

        return redirect()->intended(route($prefix . '.dashboard.index'));
    }

    public function render()
    {
        return view('modules.auth.login')->layout('layouts.guest');
    }
}

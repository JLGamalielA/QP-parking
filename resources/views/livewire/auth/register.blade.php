{{--
   Company: CETAM
   Project: QPK
   File: register.blade.php
   Created on: 15/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 15/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Initial creation of the registration view based on Volt template. |

   - ID: 2 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Integration of QPK fields maintaining single-column layout. |

   - ID: 3 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Layout fix: Replaced 'vh-lg-100' with 'min-vh-100' and added padding 'py-5' to enable scrolling on smaller screens. |

   - ID: 4 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Translated UI strings to Spanish and corrected navigation links. |
--}}

{{-- 
    LAYOUT FIX: 
    - Changed 'vh-lg-100' to 'min-vh-100' to allow the section to grow with content.
    - Added 'py-5' to ensure vertical spacing when scrolling.
    - Removed 'mt-5 mt-lg-0' as padding handles spacing now.
--}}
<section class="min-vh-100 bg-soft d-flex align-items-center py-5">
    <div class="container">
        <div wire:ignore.self class="row justify-content-center">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <h1 class="mb-0 h3">{{ __('Create Account') }}</h1>
                    </div>

                    <form wire:submit.prevent="register" action="#" method="POST">

                        {{-- First Name --}}
                        <div class="form-group mb-4">
                            <label for="first_name">{{ __('First Name') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <x-qpk-icon name="user" class="text-gray-600" />
                                </span>
                                <input wire:model="first_name" type="text" class="form-control"
                                    placeholder="{{ __('John') }}" id="first_name" autofocus required>
                            </div>
                            @error('first_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Last Name --}}
                        <div class="form-group mb-4">
                            <label for="last_name">{{ __('Last Name') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2">
                                    <x-qpk-icon name="user" class="text-gray-600" />
                                </span>
                                <input wire:model="last_name" type="text" class="form-control"
                                    placeholder="{{ __('Doe') }}" id="last_name" required>
                            </div>
                            @error('last_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone Number --}}
                        <div class="form-group mb-4">
                            <label for="phone_number">{{ __('Phone Number') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">
                                    <x-qpk-icon name="phone" class="text-gray-600" />
                                </span>
                                <input wire:model="phone_number" type="text" class="form-control"
                                    placeholder="1234567890" id="phone_number" required>
                            </div>
                            @error('phone_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Birth Date --}}
                        <div class="form-group mb-4">
                            <label for="birth_date">{{ __('Birth Date') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon4">
                                    <x-qpk-icon name="calendar" class="text-gray-600" />
                                </span>
                                <input wire:model="birth_date" type="date" class="form-control" id="birth_date"
                                    required>
                            </div>
                            @error('birth_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-4">
                            <label for="email">{{ __('Your Email') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon5">
                                    <x-qpk-icon name="email" class="text-gray-600" />
                                </span>
                                <input wire:model="email" id="email" type="email" class="form-control"
                                    placeholder="ejemplo@company.com" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block"> {{ $message }} </div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="form-group mb-4">
                            <label for="password">{{ __('Your Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon6">
                                    <x-qpk-icon name="lock" class="text-gray-600" />
                                </span>
                                <input wire:model.lazy="password" type="password" placeholder="{{ __('Password') }}"
                                    class="form-control" id="password" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block"> {{ $message }} </div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-group mb-4">
                            <label for="confirm_password">{{ __('Confirm Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon7">
                                    <x-qpk-icon name="lock" class="text-gray-600" />
                                </span>
                                <input wire:model.lazy="passwordConfirmation" type="password"
                                    placeholder="{{ __('Confirm Password') }}" class="form-control"
                                    id="confirm_password" required>
                            </div>
                        </div>

                        {{-- Terms --}}
                        <div class="form-check mb-4">
                            <input wire:model="agreement" class="form-check-input" type="checkbox" value=""
                                id="terms" required>
                            <label class="form-check-label fw-normal mb-0" for="terms">
                                {{ __('I agree to the terms and conditions') }}
                            </label>
                            @error('agreement')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-gray-800">{{ __('Sign Up') }}</button>
                        </div>
                    </form>

                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <span class="fw-normal">
                            {{ __('Already have an account?') }}
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.login') }}"
                                class="fw-bold">{{ __('Login here') }}</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

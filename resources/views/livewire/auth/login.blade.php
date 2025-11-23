{{--
   Company: CETAM
   Project: QPK
   File: login.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Refactored login view with QPK icon component and localization support. |
--}}

<section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
    <div class="container">
        <div wire:ignore.self class="row justify-content-center">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <h1 class="mb-3 h3">{{ __('Welcome back') }}</h1>
                    </div>

                    <form wire:submit.prevent="login" action="#" class="mt-4" method="POST">
                        <div class="form-group mb-4">
                            <label for="email">{{ __('Your Email') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <x-qpk-icon name="email" class="text-gray-600" />
                                </span>
                                <input wire:model="email" type="email" class="form-control"
                                    placeholder="example@company.com" id="email" autofocus required>
                            </div>
                            @error('email')
                                <div wire:key="form" class="invalid-feedback d-block"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password">{{ __('Your Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2">
                                    <x-qpk-icon name="lock" class="text-gray-600" />
                                </span>
                                <input wire:model.lazy="password" type="password" placeholder="Password"
                                    class="form-control" id="password" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-top mb-4">
                            <div class="form-check">
                                <input wire:model="remember_me" class="form-check-input" type="checkbox" value=""
                                    id="remember">
                                <label class="form-check-label mb-0" for="remember">
                                    {{ __('Remember me') }}
                                </label>
                            </div>
                            <div>
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.forgot-password') }}"
                                    class="small text-right">
                                    {{ __('Lost password?') }}
                                </a>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-gray-800">{{ __('Sign in') }}</button>
                        </div>
                    </form>

                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <span class="fw-normal">
                            {{ __('Not registered?') }}
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.register') }}"
                                class="fw-bold">{{ __('Create account') }}</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

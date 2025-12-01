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
                        <h1 class="mb-3 h3">Inicio de sesión</h1>
                    </div>

                    <form wire:submit.prevent="login" action="#" class="mt-4" method="POST">
                        <div class="form-group mb-4">
                            <label for="email">{{ __('Your Email') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <x-icon name="msg.email" class="text-gray-600" />
                                </span>
                                <input wire:model="email" type="email" class="form-control"
                                    placeholder="ejemplo@compañia.com" id="email">
                            </div>
                            @error('email')
                                <div wire:key="form" class="invalid-feedback d-block"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password">{{ __('Your Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2">
                                    <x-icon name="access.lock" class="text-gray-600" />
                                </span>
                                <input wire:model.lazy="password" type="password" placeholder="Contraseña"
                                    class="form-control" id="password">
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-gray-800">{{ __('Sign in') }}</button>
                        </div>
                    </form>

                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <span class="fw-normal">
                            ¿No estás registrado?
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.register') }}"
                                class="fw-bold text-info">Crear cuenta</a>
                        </span>
                    </div>


                </div>
            </div>
        </div>
        <div class="mt-4">
            @include('partials.footer2')
        </div>
    </div>
</section>

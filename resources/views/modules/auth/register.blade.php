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
                        <h1 class="mb-0 h3">Crear Cuenta</h1>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <x-icon name="success" class="me-2" /> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <form wire:submit.prevent="register" class="mt-4">

                        @if ($currentStep == 1)
                            <h4 class="mb-4 text-center text-primary">Datos personales</h4>
                            <div class="form-group mb-4">
                                <label for="firstName">Nombre <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model="firstName" type="text"
                                        class="form-control @error('firstName') is-invalid @enderror"
                                        placeholder="Nombre" id="firstName" autofocus maxlength="20">
                                </div>
                                @error('firstName')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="lastName">Apellido <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model="lastName" type="text"
                                        class="form-control @error('lastName') is-invalid @enderror"
                                        placeholder="Apellido" id="lastName" autofocus maxlength="30">
                                </div>
                                @error('lastName')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="phoneNumber">Teléfono <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model="phoneNumber" type="tel"
                                        class="form-control @error('phoneNumber') is-invalid @enderror"
                                        placeholder="10 dígitos" id="phoneNumber" maxlength="10"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                                @error('phoneNumber')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        @if ($currentStep == 2)
                            <h4 class="mb-4 text-center text-primary">Datos de acceso</h4>

                            <div class="form-group mb-4">
                                <label for="email">Correo Electrónico <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model.blur="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="ejemplo@institucion.com" id="email">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="password">Contraseña <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="passwordConfirmation">Confirmar Contraseña <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model="passwordConfirmation" type="password"
                                        class="form-control @error('passwordConfirmation') is-invalid @enderror"
                                        id="passwordConfirmation">
                                </div>
                                @error('passwordConfirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        @if ($currentStep == 3)
                            <h4 class="mb-4 text-center text-primary">Finalizar Registro</h4>
                            <div class="row justify-content-center">
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <div class="d-flex justify-content-center">
                                            <div class="form-check">
                                                <input wire:model="terms"
                                                    class="form-check-input @error('terms') is-invalid @enderror me-2"
                                                    type="checkbox" id="terms">
                                                <label class="form-check-label" for="terms">
                                                    <span class="text-dark">Acepto los</span>
                                                    <a href="#" class="text-info fw-bold" data-bs-toggle="modal"
                                                        data-bs-target="#termsModal">Términos de uso</a>
                                                    <span>y</span>
                                                    <a href="#" class="text-info fw-bold" data-bs-toggle="modal"
                                                        data-bs-target="#privacyModal">Aviso de privacidad</a>
                                                </label>
                                            </div>
                                        </div>
                                        @error('terms')
                                            <div class="invalid-feedback d-block text-center mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif


                        <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                            @if ($currentStep > 1)
                                <x-button type="secondary" wire:click="previousStep" class="text-white">
                                    <x-icon name="nav.back" class="me-2" /> Atrás
                                </x-button>
                            @else
                                <span></span>
                            @endif

                            @if ($currentStep < 4)
                                <x-button type="primary" wire:click="nextStep">
                                    Siguiente <x-icon name="nav.forward" class="ms-2" />
                                </x-button>
                            @else
                                <button type="submit" class="btn btn-primary text-white"
                                    wire:loading.attr="disabled">
                                    <span wire:loading wire:target="register"
                                        class="spinner-border spinner-border-sm me-2"></span>
                                    <span wire:loading.remove wire:target="register">Registrar</span>
                                    <span wire:loading wire:target="register">Procesando...</span>
                                </button>
                            @endif
                        </div>


                    </form>

                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <span class="fw-normal">
                            ¿Ya tienes cuenta?
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.login') }}"
                                class="fw-bold">Inicia Sesión </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

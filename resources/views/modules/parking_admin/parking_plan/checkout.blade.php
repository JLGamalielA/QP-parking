{{--
   Company: CETAM
   Project: QPK
   File: checkout.blade.php
   Created on: 07/12/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 07/12/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Checkout view for completing the purchase of a parking plan. |
--}}

<div class="py-2 animate_animated animate_fadeIn">

    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="{{ route('qpk.parking-plans.index') }}"><x-icon name="nav.home" size="xs" /></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('qpk.parking-plans.index') }}">Suscripción</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Pago</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Finalizar Compra</h2>
            <p class="mb-0"> Completa los datos para activar tu plan
                {{ $subscription->name }}. </p>
        </div>
    </div>

    <form wire:submit.prevent="processPayment">
        <div class="row g-4">
            <div class="col-lg-8">
                <x-card>
                    <h5 class="h6 fw-bold text-primary mb-4">Datos de Pago</h5>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nombre en la Tarjeta <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control py-2 @error('cardName') is-invalid @enderror"
                            wire:model="cardName" placeholder="Titular de la Tarjeta" maxlength="50">
                        @error('cardName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Número de Tarjeta <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="fa-regular fa-credit-card text-muted"></i></span>
                            <input type="text"
                                class="form-control py-2 ps-0 @error('cardNumber') is-invalid @else border-start-0 @enderror"
                                wire:model="cardNumber" placeholder="0000 0000 0000 0000" maxlength="16">
                        </div>
                        @error('cardNumber')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold small">Vencimiento <span
                                    class="text-danger">*</span></label>

                            <div class="input-group">
                                <input type="text"
                                    class="form-control py-2 text-center @error('cardExpiryMonth') is-invalid @else border-end-0 @enderror"
                                    wire:model="cardExpiryMonth" placeholder="MM" maxlength="2">

                                <span
                                    class="input-group-text bg-white border-start-0 border-end-0 fw-bold px-1">/</span>

                                <input type="text"
                                    class="form-control py-2 text-center @error('cardExpiryYear') is-invalid @else border-start-0 @enderror"
                                    wire:model="cardExpiryYear" placeholder="AA" maxlength="2">
                            </div>

                            @error('cardExpiryMonth')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            @error('cardExpiryYear')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold small">CVC <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text"
                                    class="form-control py-2 @error('cardCvc') is-invalid @else border-end-0 @enderror"
                                    wire:model="cardCvc" placeholder="CVV" maxlength="3">
                                <span class="input-group-text bg-white border-start-0"><i
                                        class="fa-solid fa-lock text-muted small"></i></span>
                            </div>
                            @error('cardCvc')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="col-lg-4">
                <x-card class=" d-flex flex-column">
                    <h5 class="h6 fw-bold text-gray-800 mb-3">Resumen</h5>

                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Plan Seleccionado:</span>
                        <span class="fw-bold text-dark">{{ $subscription->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-muted">Precio Mensual:</span>
                        <span class="fw-bold text-dark">${{ number_format($subscription->price, 2) }}</span>
                    </div>

                    <hr class="text-muted my-3 opacity-25">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold h5 mb-0">Total a Pagar</span>
                        <span class="fw-bold h4 mb-0 text-primary">${{ number_format($subscription->price, 2) }}</span>
                    </div>

                    <div class="mt-auto">
                        <x-button type="primary" class="w-100 justify-content-center py-2 fw-bold shadow-sm"
                            submit="true">
                            <span wire:loading.remove>Pagar Ahora</span>
                            <span wire:loading>
                                Procesando...
                            </span>
                        </x-button>
                    </div>
                </x-card>
            </div>

        </div>
    </form>

</div>

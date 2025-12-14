{{--
   Company: CETAM
   Project: QPK
   File: edit.blade.php
   Created on: 04/12/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Date: 04/12/2025
     Modified by: Daniel Yair Mendoza Alvarez
     Description: Edit view to modify the details of a subscription plan
--}}

@extends('layouts.admin')

@section('title', 'Editar suscripción')

@section('content')
    <div class="py-2">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.admin-dashboard.index') }}"><x-icon name="nav.home" size="xs" /></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.subscriptions.index') }}">Suscripciones</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
            <div class="d-block mb-4 mb-md-0">
                <h2 class="h4">Editar suscripción</h2>
                <p class="mb-0">Modifica la información básica de la suscripción seleccionada.</p>
            </div>
        </div>

        <form action="{{ route('qpk.subscriptions.update', $subscription->subscription_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-1">
                <div class="col-12">
                    <x-card>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    Nombre del Plan <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $subscription->name) }}"
                                    placeholder="Ingresa el nombre del plan" maxlength="15">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">
                                    Precio (MXN) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group has-validation">
                                    <input type="number" step="any"
                                        class="form-control limit-chars @error('price') is-invalid @enderror" id="price"
                                        name="price" value="{{ old('price', $subscription->price) }}"
                                        data-max="6">

                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 d-flex justify-content-start gap-2">
                                <x-button type="primary" :submit="true">
                                    <x-icon name="action.save" class="me-2" />
                                    Guardar
                                </x-button>
                                <x-button type="cancel" href="{{ route('qpk.subscriptions.index') }}">
                                    Cancelar
                                </x-button>
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/alert-handler.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
@endsection

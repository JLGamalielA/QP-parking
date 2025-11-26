{{--
   Company: CETAM
   Project: QPK
   File: create.blade.php
   Created on: 25/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez
   
   Changelog:
   - ID: 1 | Modified on: 25/11/2025 | 
     Modified by: Daniel Yair Mendoza Alvarez | 
     Description: Create form for Special Parking Roles. |
   - ID: 2 | Modified on: 26/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Standardization of action buttons using x-button component and strict adherence to Table 2 color palette (Secondary for Cancel). |
--}}

@extends('layouts.app')

@section('title', 'Crear Tipo de Usuario')

@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.dashboard.index') }}"><x-icon name="home" class="icon-xxs" /></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.special-parking-roles.index') }}">Tipos de Usuario</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Crear</li>
            </ol>
        </nav>

        <form action="{{ route('qpk.special-parking-roles.store') }}" method="POST">
            @csrf

            <div class="row mb-1">
                <div class="col-12">
                    <x-card title="Información del Tipo de Usuario">
                        <div class="row">
                            {{-- Type Name --}}
                            <div class="col-12 mb-3">
                                <label for="type" class="form-label">
                                    Nombre del tipo de usuario <span class="text-danger">*</span>
                                </label>
                                <input type="text" maxlength="150"
                                    class="form-control @error('type') is-invalid @enderror" id="type" name="type"
                                    value="{{ old('type') }}" placeholder="Ingresa el nombre del tipo de usuario">
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Commission Value --}}
                            <div class="col-12 col-md-6 mb-3">
                                <label for="special_commission_value" class="form-label">
                                    Valor de comisión <span class="text-danger">*</span>
                                </label>
                                <div class="input-group has-validation">
                                    <input type="number" step="any"
                                        class="form-control @error('special_commission_value') is-invalid @enderror"
                                        id="special_commission_value" name="special_commission_value"
                                        value="{{ old('special_commission_value') }}" placeholder="0.00">
                                    @error('special_commission_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Commission Period --}}
                            <div class="col-12 col-md-6 mb-3">
                                <label for="special_commission_period" class="form-label">
                                    Periodo de comisión <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('special_commission_period') is-invalid @enderror"
                                    id="special_commission_period" name="special_commission_period">
                                    <option value="" selected disabled>Selecciona</option>
                                    <option value="3600"
                                        {{ old('special_commission_period') == '3600' ? 'selected' : '' }}>Hora</option>
                                    <option value="86400"
                                        {{ old('special_commission_period') == '86400' ? 'selected' : '' }}>Día</option>
                                </select>
                                @error('special_commission_period')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>

            <div class="row">
                <div class="col-12 d-flex justify-content-start gap-2">
                    {{-- Save Button: Primary type according to Table 2 --}}
                    <x-button type="primary" :submit="true">
                        <x-icon name="save" class="me-2" />
                        Guardar
                    </x-button>

                    {{-- Cancel Button: Secondary type according to Table 2 and Cancel Icon according to Table 5 --}}
                    <x-button type="secondary" href="{{ route('qpk.special-parking-roles.index') }}">
                        <x-icon name="cancel" class="me-2" />
                        Cancelar
                    </x-button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/alert-handler.js') }}"></script>
@endsection

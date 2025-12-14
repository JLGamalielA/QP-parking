{{--
   Company: CETAM
   Project: QPK
   File: edit.blade.php
   Created on: 25/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez
   
   Changelog:
   - ID: 1 | Modified on: 25/11/2025 | 
     Modified by: Daniel Yair Mendoza Alvarez | 
     Description: Edit form for Special Parking Roles. |
   - ID: 2 | Modified on: 26/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Standardization of action buttons using x-button component and strict adherence to Table 2 color palette (Secondary for Cancel). |
--}}

@extends('layouts.app')

@section('title', 'Editar Tipo de Usuario')

@section('content')
    <div class="py-2">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.dashboard.index') }}"><x-icon name="nav.home" size="xs" /></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.special-parking-roles.index') }}">Tipos de Usuario</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
            <div class="d-block mb-4 mb-md-0">
                <h2 class="h4">Editar tipo de usuario</h2>
                <p class="mb-0"> Edita la información de tu tipo de usuario. </p>
            </div>
        </div>

        <form action="{{ route('qpk.special-parking-roles.update', $role->special_parking_role_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-1">
                <div class="col-12">
                    <x-card>
                        <div class="row">
                            {{-- Type Name --}}
                            <div class="col-12 mb-3">
                                <label for="type" class="form-label">
                                    Nombre del tipo de usuario <span class="text-danger">*</span>
                                </label>
                                <input type="text" maxlength="80"
                                    class="form-control @error('type') is-invalid @enderror" id="type" name="type"
                                    value="{{ old('type', $role->type) }}"
                                    placeholder="Ingresa el nombre del tipo de usuario">
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
                                        class="form-control limit-chars @error('special_commission_value') is-invalid @enderror"
                                        id="special_commission_value" name="special_commission_value"
                                        value="{{ old('special_commission_value', $role->special_commission_value) }}"
                                        data-max="6">
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
                                    <option value="" disabled>Selecciona</option>

                                    @php
                                        // Retrieve old input or database value
                                        $val = old('special_commission_period', $role->special_commission_period);
                                    @endphp

                                    <option value="3600" {{ $val == '3600' ? 'selected' : '' }}>Hora</option>
                                    <option value="-1" {{ $val == '-1' ? 'selected' : '' }}>Tiempo libre</option>
                                </select>
                                @error('special_commission_period')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 d-flex justify-content-start gap-2">
                                <x-button type="primary" :submit="true">
                                    <x-icon name="action.save" class="me-2" />
                                    Guardar
                                </x-button>
                                <x-button type="cancel" href="{{ route('qpk.special-parking-roles.index') }}">
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

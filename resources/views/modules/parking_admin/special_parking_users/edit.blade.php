{{--
   Company: CETAM
   Project: QPK
   File: edit.blade.php
   Created on: 26/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 26/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Edit form for Special Parking User (Role, Expiration, Status). |
--}}

@extends('layouts.app')

@section('title', 'Editar Usuario Especial')

@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.dashboard.index') }}"><x-icon name="home" class="icon-xxs" /></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.special-parking-users.index') }}">Usuarios Especiales</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </nav>

        <form action="{{ route('qpk.special-parking-users.update', $specialParkingUser->special_parking_user_id) }}"
            method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12">
                    <x-card>
                        <div class="row">
                            {{-- Role Selection --}}
                            <div class="col-12 col-md-6 mb-3">
                                <label for="special_parking_role_id" class="form-label">
                                    Rol Asignado <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('special_parking_role_id') is-invalid @enderror"
                                    id="special_parking_role_id" name="special_parking_role_id">
                                    <option value="" disabled>Selecciona un rol</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->special_parking_role_id }}"
                                            {{ old('special_parking_role_id', $specialParkingUser->special_parking_role_id) == $role->special_parking_role_id ? 'selected' : '' }}>
                                            {{ $role->type }} (${{ $role->special_commission_value }} /
                                            {{ $role->special_commission_period == 3600 ? 'Hr' : 'Día' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('special_parking_role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Expiration Date --}}
                            <div class="col-12 col-md-6 mb-3">
                                <label for="permission_end_date" class="form-label">
                                    Fecha de Vencimiento <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                    class="form-control @error('permission_end_date') is-invalid @enderror"
                                    id="permission_end_date" name="permission_end_date"
                                    value="{{ old('permission_end_date', $specialParkingUser->permission_end_date->format('Y-m-d')) }}"
                                    min="{{ date('Y-m-d') }}">
                                @error('permission_end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </x-card>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12 d-flex justify-content-start gap-2">
                    {{-- Update Button: Primary --}}
                    <x-button type="primary" :submit="true">
                        <x-icon name="save" class="me-2" />
                        Guardar
                    </x-button>

                    {{-- Cancel Button: Secondary --}}
                    <x-button type="secondary" href="{{ route('qpk.special-parking-users.index') }}">
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

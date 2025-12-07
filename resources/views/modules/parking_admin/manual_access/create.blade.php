{{--
   Company: CETAM
   Project: QPK
   File: create.blade.php
   Created on: 06/12/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez
   
   Changelog:
   - ID: 1 | Modified on: 06/12/2025 | 
     Modified by: Daniel Yair Mendoza Alvarez | 
     Description: Create form for handling manual access registration. |
--}}

@extends('layouts.app')

@section('title', 'Registro manual')

@section('content')
    <div class="py-2">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.dashboard.index') }}"><x-icon name="nav.home" size="xs" /></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.parking-entries.index') }}">Lectores</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Registro manual</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
            <div class="d-block mb-4 mb-md-0">
                <h2 class="h4">Registro manual</h2>
                <p class="mb-0"> Registra una entrada/salida al estacionamiento usando el número de teléfono del usuario.
                </p>
            </div>
        </div>

        <form action="{{ route('qpk.parking-entries.manual-access.store', $parkingEntry->parking_entry_id) }}"
            method="POST">
            @csrf

            <input type="hidden" name="parking_entry_id" value="{{ $parkingEntry->parking_entry_id }}">

            <div class="row mb-1">
                <div class="col-12">
                    <x-card>
                        <div class="row">
                            {{-- User Phone Number --}}
                            <div class="col-12 mb-3">
                                <label for="phone_number" class="form-label">
                                    Número de teléfono <span class="text-danger">*</span>
                                </label>
                                <input type="text" maxlength="10"
                                    class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                                    name="phone_number" value="{{ old('phone_number') }}"
                                    placeholder="Ingresa el número de teléfono del usuario">
                                @error('phone_number')
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
    @if (session('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (typeof window.showSessionAlert === 'function') {
                    window.showSessionAlert(@json(session('swal')));
                }
            });
        </script>
    @endif
@endsection

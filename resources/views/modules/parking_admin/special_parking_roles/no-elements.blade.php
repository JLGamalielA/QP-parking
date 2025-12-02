{{--
    Company: CETAM
    Project: QPK
    File: no-elements.blade.php
    Created on: 25/11/2025
    Created by: Daniel Yair Mendoza Alvarez
    Approved by: Daniel Yair Mendoza Alvarez
    
    Changelog:
    - ID: 1 | Modified on: 25/11/2025 | 
      Modified by: Daniel Yair Mendoza Alvarez | 
      Description: Empty state view for Special Roles. |
--}}

@extends('layouts.app')

@section('title', 'Tipos de Usuario')

@section('content')
    <div class="py-2">
        <x-breadcrumb :items="[['label' => 'Tipos de Usuario']]" />

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
            <div class="d-block mb-4 mb-md-0">
                <h2 class="h4">Tipos de usuarios</h2>
                <p class="mb-0">Consulta los tipos de usuarios registrados en tu estacionamiento.</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <x-button type="primary" :href="route('qpk.special-parking-roles.create')">
                    <x-icon name="action.create" class="me-2 text-white" />
                    Crear tipo de usuario
                </x-button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                <x-card>
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <span class="text-gray-200">
                                <x-icon name="user.admin" size="2x" />
                            </span>
                        </div>
                        <h2 class="h5 fw-bold text-gray-800 mb-3">
                            Aún no has registrado tipos de usuario.
                        </h2>
                        <p class="text-gray-500 mb-4">
                            Define roles especiales para aplicar tarifas diferenciadas.
                        </p>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/alert-handler.js') }}"></script>
    @if (session('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showSessionAlert(@json(session('swal')));
            });
        </script>
    @endif
@endsection

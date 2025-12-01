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
    <div class="py-4">
        <div class="row justify-content-center mt-4">
            <div class="col-12">
                <x-card>
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <span class="text-gray-200">
                                <x-icon name="user.gear" size="2x" />
                            </span>
                        </div>
                        <h2 class="h5 fw-bold text-gray-800 mb-3">
                            Aún no has registrado tipos de usuario.
                        </h2>
                        <p class="text-gray-500 mb-4">
                            Define roles especiales para aplicar tarifas diferenciadas.
                        </p>
                        <a href="{{ route('qpk.special-parking-roles.create') }}"
                            class="btn btn-gray-800 d-inline-flex align-items-center">
                            <x-icon name="action.create" class="me-2 text-white" />
                            Crear Tipo de Usuario
                        </a>
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

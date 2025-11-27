{{--
   Company: CETAM
   Project: QPK
   File: no-elements.blade.php
   Created on: 26/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 26/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Empty state view for Special Parking Users. |
--}}

@extends('layouts.app')

@section('title', 'Usuarios Especiales')

@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.dashboard.index') }}"><x-icon name="home" class="icon-xxs" /></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Usuarios Especiales</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-12">
                <x-card>
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <span class="text-gray-200">
                                {{-- User Shield icon representing special permissions --}}
                                <x-icon name="userShield" size="3x" />
                            </span>
                        </div>
                        <h2 class="h5 fw-bold text-gray-800 mb-3">
                            No hay usuarios especiales registrados.
                        </h2>
                        <p class="text-gray-500 mb-4">
                            Gestiona los permisos y roles especiales desde el apartado de Solicitudes.
                        </p>
                        {{-- Action button guiding to Applications --}}
                        <a href="{{ route('qpk.special-user-applications.index') }}"
                            class="btn btn-gray-800 d-inline-flex align-items-center">
                            <x-icon name="inbox" class="icon-xs me-2 text-white" />
                            Ver Solicitudes
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
                if (typeof window.showSessionAlert === 'function') {
                    window.showSessionAlert(@json(session('swal')));
                }
            });
        </script>
    @endif
@endsection

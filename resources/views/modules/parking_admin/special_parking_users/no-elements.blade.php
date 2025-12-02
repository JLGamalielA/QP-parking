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
    <div class="py-2">
        <x-breadcrumb :items="[['label' => 'Usuarios especiales']]" />
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
            <div class="d-block mb-4 mb-md-0">
                <h2 class="h4">Usuarios Especiales</h2>
                <p class="mb-0">Consulta los usuarios especiales de tu estacionamiento.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <x-card>
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <span class="text-gray-200">
                                <x-icon name="user.list" size="2x" />
                            </span>
                        </div>
                        <h2 class="h5 fw-bold text-gray-800 mb-3">
                            No hay usuarios especiales registrados.
                        </h2>
                        <p class="text-gray-500 mb-4">
                            Consulta el apartado de solicitudes para gestionar usuarios especiales.
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
                if (typeof window.showSessionAlert === 'function') {
                    window.showSessionAlert(@json(session('swal')));
                }
            });
        </script>
    @endif
@endsection

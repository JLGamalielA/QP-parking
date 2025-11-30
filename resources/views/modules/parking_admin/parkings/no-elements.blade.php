{{--
   Company: CETAM
   Project: QPK
   File: no-elements.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Empty state view for Parkings module using standardized cards, typography, and action buttons. |
--}}

@extends('layouts.app')

@section('title', 'Estacionamientos')

@section('content')
    <div class="py-4">
        <div class="row justify-content-center mt-4">
            <div class="col-12">
                <x-card>
                    <div class="text-center py-5">

                        <div class="mb-4">
                            <span class="text-gray-200">
                                <x-icon name="mapMarker" size="3x" />
                            </span>
                        </div>
                        {{-- Main Title (Typography h5/h4 based on Section 8.2.5) --}}
                        <h2 class="h5 fw-bold text-gray-800 mb-3">
                            Aún no se han registrado estacionamientos en el sistema.
                        </h2>
                        {{-- Helper Text (Microcopy Section 7.6: Clear and Empathetic) --}}
                        <p class="text-gray-500 mb-4">
                            Crea un nuevo estacionamiento para comenzar a gestionarlo.
                        </p>

                        <x-button type="primary" :href="route('qpk.parkings.create')">
                            <x-icon name="add" class="icon-xs me-2 text-white" />
                            Crear estacionamiento
                        </x-button>
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
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof window.showSessionAlert === 'function') {
                    window.showSessionAlert(@json(session('swal')));
                }
            });
        </script>
    @endif
@endsection

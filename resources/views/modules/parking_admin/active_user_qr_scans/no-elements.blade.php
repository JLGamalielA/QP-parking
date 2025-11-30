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
     Description: View displayed when there are no active parking entries (empty parking).
--}}

@extends('layouts.app')

@section('title', 'Entradas Activas')

@section('content')
    <div class="py-2">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.dashboard.index') }}"><x-icon name="home" class="icon-xxs" /></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Entradas Activas</li>
            </ol>
        </nav>

        <div class="row justify-content-center ">
            <div class="col-12">
                <x-card>
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <span class="text-gray-200">
                                {{-- Icon: Car/Parking representation --}}
                                <x-icon name="mapMarker" size="3x" />
                            </span>
                        </div>
                        <h2 class="h5 fw-bold text-gray-800 mb-3">
                            El estacionamiento está vacío.
                        </h2>
                        <p class="text-gray-500 mb-4">
                            No hay usuarios actualmente dentro de las instalaciones.
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

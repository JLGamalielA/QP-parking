{{--
   Company: CETAM
   Project: QPK
   File: index.blade.php
   Created on: 26/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 26/11/2025 |
    Modified by: Daniel Yair Mendoza Alvarez |
    Description: Index view for Special User Applications. |
   - ID: 2 | Modified on: 26/11/2025 |
    Modified by: Daniel Yair Mendoza Alvarez |
    Description: Decoupled JS logic. Removed inline scripts and added data-attributes for external handler. |
--}}

@extends('layouts.app')

@section('title', 'Solicitudes')

@section('content')
    <x-breadcrumb :items="[['label' => 'Solicitudes']]" />

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Solicitudes</h2>
            <p class="mb-0">Consulta las solicitudes de usuarios especiales de tu estacionamiento.</p>
        </div>
    </div>
    <livewire:parking.special-user-applications-table />
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/alert-handler.js') }}"></script>
    {{-- Load Search Logic --}}
    <script src="{{ mix('js/modules/parking/search-handler.js') }}"></script>

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

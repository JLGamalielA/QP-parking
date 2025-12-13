{{--
   Company: CETAM
   Project: QPK
   File: index.blade.php
   Created on: 03/12/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 03/12/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Index view to consult all the users in the system. |
--}}

@extends('layouts.admin')

@section('title', 'Inicio')

@section('content')
    <x-admin-breadcrumb :items="[['label' => 'Inicio']]" />

    {{-- Header Section --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Inicio</h2>
            <p class="mb-0">Consulta general de usuarios registrados en el sistema.</p>
        </div>
    </div>

    <livewire:admin.users-table />
    
@endsection

@section('scripts')
    <script src="{{ mix('js/modules/admin/subscription-handler.js') }}"></script>
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

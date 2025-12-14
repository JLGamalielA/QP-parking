{{--
   Company: CETAM
   Project: QPK
   File: index.blade.php
   Created on: 26/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Date: 26/11/2025
     Modified by: Daniel Yair Mendoza Alvarez
     Description: Index view for Active User QR Scans

   - ID: 2 | Date: 26/11/2025
     Modified by: Daniel Yair Mendoza Alvarez
     Description: Applied 'Warning' style to 'Liberar' button representing an administrative intervention
--}}

@extends('layouts.app')

@section('title', 'Entradas Activas')

@section('content')
    <x-breadcrumb :items="[['label' => 'Entradas Activas']]" />
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Entradas Activas</h2>
            <p class="mb-0">Consulta las entradas activas de tu estacionamiento</p>
        </div>
    </div>

    <livewire:parking.active-scans-table :parking-id="$parking->parking_id" />

    <x-modal id="exitQrModal" title="Codigo qr de salida">
        <div class="text-center">
            <div id="qrContainer" class="d-flex justify-content-center mb-3">
                <div class="spinner-border text-primary" role="status">
                </div>
            </div>

            <div class="mb-3">
                <small class="fw-bold">Monto:</small>
                <h2 class="h1 fw-bold mb-0" id="qrAmountDisplay"></h2>
            </div>

            <div class=" d-flex align-items-center justify-content-center">
                <span id="qrSuccessMessage" class="fw-bold"></span>
            </div>

        </div>
    </x-modal>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/alert-handler.js') }}"></script>
    <script src="{{ mix('js/utils/active-scans.js') }}"></script>
    <script src="{{ mix('js/utils/exit-qr.js') }}"></script>
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

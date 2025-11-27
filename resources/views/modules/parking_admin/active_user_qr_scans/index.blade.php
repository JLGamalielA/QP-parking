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
     Description: Index view for Active User QR Scans.
   - ID: 2 | Modified on: 26/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Applied 'Warning' style to 'Liberar' button representing an administrative intervention.
--}}

@extends('layouts.app')

@section('title', 'Entradas Activas')

@section('content')
    {{-- Header Container --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-4">
        <div class="d-block mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('qpk.dashboard.index') }}"><x-icon name="home" class="icon-xxs" /></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Entradas Activas</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- Search Bar --}}
    <div class="btn-toolbar mb-3">
        <form method="GET" action="{{ route('qpk.active-user-qr-scans.index') }}" class="d-flex">
            <div class="input-group me-2 me-lg-3">
                <span class="input-group-text">
                    <x-icon name="search" />
                </span>
                <input type="text" name="search" class="form-control search-input" placeholder="Buscar por teléfono."
                    value="{{ $search ?? '' }}" maxlength="10" autocomplete="off">
            </div>
        </form>
    </div>

    {{-- Content Wrapper --}}
    <div class="card shadow border-0 table-wrapper">
        @if ($activeEntries->isNotEmpty())
            {{-- Table Content --}}
            <div class="card-body pb-0">
                <table class="table user-table align-items-center mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-bottom text-uppercase">Nombre de la Entrada</th>
                            <th class="border-bottom text-uppercase">Nombre del Usuario</th>
                            <th class="border-bottom text-uppercase">Teléfono</th>
                            <th class="border-bottom text-uppercase">Liberar Entrada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activeEntries as $scan)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-gray-900">
                                            {{ $scan->parkingEntry->name }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-normal text-gray-900">
                                            {{ $scan->user->first_name }} {{ $scan->user->last_name }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-normal text-gray-600">
                                        {{ $scan->user->phone_number ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center"
                                        onclick="confirmRelease('{{ $scan->active_user_qr_scan_id }}')">
                                        <x-icon name="unlock" class="icon-xs me-2 text-white" />
                                        Liberar
                                    </button>

                                    <form id="release-form-{{ $scan->active_user_qr_scan_id }}"
                                        action="{{ route('qpk.active-user-qr-scans.destroy', $scan->active_user_qr_scan_id) }}"
                                        method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div
                class="card-footer bg-white border-0 pt-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                {{ $activeEntries->links() }}
            </div>
        @else
            {{-- No Results Found State --}}
            <div class="card-body">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <span class="text-gray-200">
                            <x-icon name="phone" size="3x" />
                        </span>
                    </div>
                    <h2 class="h5 fw-bold text-gray-800 mb-3">
                        No se encontraron resultados.
                    </h2>
                    <p class="text-gray-500 mb-4">
                        El número de teléfono buscado <strong>"{{ $search }}"</strong> no se encuentra en nuestros
                        registros de entradas activas.
                    </p>

                    <x-button type="primary" :href="route('qpk.active-user-qr-scans.index')">
                        <x-icon name="view" class="icon-xs me-2 text-white" />
                        Ver entradas activas
                    </x-button>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/alert-handler.js') }}"></script>

    {{-- Load Search Handler Module --}}
    <script src="{{ mix('js/modules/parking/search-handler.js') }}"></script>

    <script>
        // SweetAlert2 logic remains here as it's tied to Blade IDs iteration
        function confirmRelease(id) {
            Swal.fire({
                title: '¿Liberar entrada manualmente?',
                text: "Esta es una intervención administrativa. Se forzará la salida del usuario.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#E11D48',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Sí, liberar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('release-form-' + id).submit();
                }
            });
        }
    </script>

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

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
     Description: Applied 'Warning' style to 'Liberar' button representing an administrative intervention. |
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
    {{-- Search Bar --}}
    <div class="btn-toolbar mb-2">
        <form method="GET" action="{{ route('qpk.active-user-qr-scans.index') }}" class="d-flex">
            <div class="input-group me-2 me-lg-3">
                <span class="input-group-text">
                    <x-icon name="action.search" size="xs" />
                </span>
                <input type="text" name="search" class="form-control search-input" placeholder="Buscar por teléfono."
                    value="{{ $search ?? '' }}" maxlength="10" autocomplete="off">
            </div>
        </form>
    </div>

    {{-- Content Wrapper --}}
    <div class="py-2">
        @if ($activeEntries->isNotEmpty())
            {{-- Table Content --}}
            <div class="card card-body border-0 shadow table-wrapper table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-bottom text-uppercase">Nombre de la Entrada</th>
                            <th class="border-bottom text-uppercase">Nombre del Usuario</th>
                            <th class="border-bottom text-uppercase">Teléfono</th>
                            <th class="border-bottom text-uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activeEntries as $scan)
                            <tr>
                                <td>
                                    <span class="fw-bold text-gray-900 text-wrap">
                                        {{ $scan->parkingEntry->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-normal text-gray-900 text-wrap">
                                        {{ $scan->user->first_name }} {{ $scan->user->last_name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-normal text-gray-600">
                                        {{ $scan->user->phone_number }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <x-icon name="action.more" size="xs" />
                                            <span class="visually-hidden">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                            <button class="dropdown-item d-flex align-items-center"
                                                onclick="confirmRelease('{{ $scan->active_user_qr_scan_id }}')">
                                                <x-icon name="action.scan" size="xs" class=" me-2 text-gray-400" />
                                                Generar qr de salida
                                            </button>
                                        </div>
                                    </div>
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
                <div
                    class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                    {{ $activeEntries->links('partials.pagination') }}
                    <div class="fw-normal small mt-4 mt-lg-0">
                        Mostrando <b>{{ $activeEntries->firstItem() }}</b> al <b>{{ $activeEntries->lastItem() }}</b> de
                        <b>{{ $activeEntries->total() }}</b> entradas activas
                    </div>
                </div>
            </div>
        @else
            {{-- No Results Found State --}}
            <div class="card card-body border-0 shadow">
                <div class="text-center py-2">
                    <div class="mb-4">
                        <span class="text-gray-200">
                            <x-icon name="action.search" size="2x" />
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
                        <x-icon name="action.view" class="me-2 text-white" />
                        Ver entradas activas
                    </x-button>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/alert-handler.js') }}"></script>
    <script src="{{ mix('js/utils/active-scans.js') }}"></script>
    {{-- Load Search Handler Module --}}
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

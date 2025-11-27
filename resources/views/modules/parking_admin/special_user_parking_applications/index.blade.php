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
    {{-- Header y Search (Igual que antes) --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-4">
        <div class="d-block mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('qpk.dashboard.index') }}"><x-icon name="home" class="icon-xxs" /></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Solicitudes</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="btn-toolbar mb-3">
        <form method="GET" action="{{ route('qpk.special-user-parking-applications.index') }}" class="d-flex">
            <div class="input-group me-2 me-lg-3">
                <span class="input-group-text"><x-icon name="search" /></span>
                <input type="text" name="search" class="form-control search-input" placeholder="Buscar por teléfono."
                    value="{{ $search ?? '' }}" maxlength="10" autocomplete="off">
            </div>
        </form>
    </div>

    <div class="card shadow border-0 table-wrapper">
        @if ($applications->isNotEmpty())
            <div class="card-body pb-0">
                <table class="table user-table align-items-center mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-bottom text-uppercase">Nombre del Usuario</th>
                            <th class="border-bottom text-uppercase">Teléfono</th>
                            <th class="border-bottom text-uppercase">Tipo Solicitado</th>
                            <th class="border-bottom text-uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $app)
                            <tr>
                                <td>
                                    <span class="fw-bold text-gray-900">
                                        {{ $app->user->first_name }} {{ $app->user->last_name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-normal text-gray-600">
                                        {{ $app->user->phone_number }}
                                    </span>
                                </td>
                                <td>
                                    {{ $app->specialParkingRole->type }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <x-icon name="ellipsis" class="icon-xs" />
                                        </button>
                                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">

                                            {{-- Approve Trigger --}}
                                            {{-- Class 'btn-approve-request' connects to application-handler.js --}}
                                            <button
                                                class="dropdown-item d-flex align-items-center text-success btn-approve-request"
                                                data-id="{{ $app->special_user_parking_application_id }}">
                                                <x-icon name="check" class="icon-xs me-2" />
                                                Aprobar
                                            </button>

                                            {{-- Reject Trigger --}}
                                            {{-- Class 'btn-reject-request' connects to application-handler.js --}}
                                            <button
                                                class="dropdown-item d-flex align-items-center text-danger btn-reject-request"
                                                data-id="{{ $app->special_user_parking_application_id }}">
                                                <x-icon name="cancel" class="icon-xs me-2" />
                                                Rechazar
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Hidden Forms (Targeted by JS via ID) --}}
                                    <form id="approve-form-{{ $app->special_user_parking_application_id }}"
                                        action="{{ route('qpk.special-user-applications.approve', $app->special_user_parking_application_id) }}"
                                        method="POST" class="d-none">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="permission_end_date"
                                            id="end-date-{{ $app->special_user_parking_application_id }}">
                                    </form>

                                    <form id="reject-form-{{ $app->special_user_parking_application_id }}"
                                        action="{{ route('qpk.special-user-parking-applications.destroy', $app->special_user_parking_application_id) }}"
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
                {{ $applications->links() }}
            </div>
        @else
            {{-- Empty State Search --}}
            <div class="card-body">
                <div class="text-center py-5">
                    <div class="mb-4"><span class="text-gray-200"><x-icon name="phone" size="3x" /></span></div>
                    <h2 class="h5 fw-bold text-gray-800 mb-3">No se encontraron resultados.</h2>
                    <p class="text-gray-500 mb-4">El número <strong>"{{ $search }}"</strong> no coincide con ninguna
                        solicitud.</p>
                    <a href="{{ route('qpk.special-user-parking-applications.index') }}" class="btn btn-sm btn-gray-800">
                        <x-icon name="back" class="me-2" /> Limpiar búsqueda
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/alert-handler.js') }}"></script>
    {{-- Load Search Logic --}}
    <script src="{{ mix('js/modules/parking/search-handler.js') }}"></script>
    {{-- Load Application Action Logic --}}
    <script src="{{ mix('js/modules/parking/application-handler.js') }}"></script>

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

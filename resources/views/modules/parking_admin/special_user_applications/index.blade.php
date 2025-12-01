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
    <div class="btn-toolbar mb-2">
        <form method="GET" action="{{ route('qpk.special-user-applications.index') }}" class="d-flex">
            <div class="input-group me-2 me-lg-3">
                <span class="input-group-text"><x-icon name="action.search" /></span>
                <input type="text" name="search" class="form-control search-input" placeholder="Buscar por teléfono."
                    value="{{ $search ?? '' }}" maxlength="10" autocomplete="off">
            </div>
        </form>
    </div>

    <div class="py-2">
        @if ($applications->isNotEmpty())
            <div class="card card-body border-0 shadow table-wrapper table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-bottom text-uppercase">Nombre del usuario</th>
                            <th class="border-bottom text-uppercase">Teléfono</th>
                            <th class="border-bottom text-uppercase">Tipo de usuario solicitado</th>
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
                                            <x-icon name="action.more" size="xs" />
                                        </button>
                                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">

                                            {{-- Approve Trigger --}}
                                            <button class="dropdown-item d-flex align-items-center text-success"
                                                onclick="document.getElementById('approve-form-{{ $app->special_user_application_id }}').submit();">
                                                <x-icon name="state.success" size="xs" class="me-2" />
                                                Aprobar
                                            </button>

                                            {{-- Reject Trigger --}}
                                            <button class="dropdown-item d-flex align-items-center text-danger"
                                                onclick="confirmDelete('{{ $app->special_user_application_id }}')">
                                                <x-icon name="action.delete" size="xs" class="text-danger me-2" />
                                                Eliminar
                                            </button>
                                        </div>
                                    </div>

                                    <form id="approve-form-{{ $app->special_user_application_id }}"
                                        action="{{ route('qpk.special-user-applications.approve', $app->special_user_application_id) }}"
                                        method="POST" class="d-none">
                                        @csrf @method('PUT')
                                    </form>
                                    <form id="delete-form-{{ $app->special_user_application_id }}"
                                        action="{{ route('qpk.special-user-applications.destroy', $app->special_user_application_id) }}"
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
                    {{ $applications->links('partials.pagination') }}
                    <div class="fw-normal small mt-4 mt-lg-0">
                        Mostrando <b>{{ $applications->firstItem() }}</b> al <b>{{ $applications->lastItem() }}</b> de
                        <b>{{ $applications->total() }}</b> solicitudes
                    </div>
                </div>
            </div>
        @else
            {{-- Empty State Search --}}
            <div class="text-center py-2">
                <div class="mb-4"><span class="text-gray-200"><x-icon name="msg.phone" size="2x" /></span></div>
                <h2 class="h5 fw-bold text-gray-800 mb-3">No se encontraron resultados.</h2>
                <p class="text-gray-500 mb-4">El número <strong>"{{ $search }}"</strong> no coincide con ninguna
                    solicitud.</p>
                <x-button type="primary" :href="route('qpk.special-user-applications.index')">
                    <x-icon name="action.view" class="me-2 text-white" />
                    Ver todas las solicitudes
                </x-button>
            </div>
        @endif
    </div>
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

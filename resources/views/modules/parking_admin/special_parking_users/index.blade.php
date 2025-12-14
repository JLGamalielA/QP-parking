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
     Description: Index view for Special Parking Users with Role Filter. |
--}}

@extends('layouts.app')

@section('title', 'Usuarios especiales')

@section('content')
    <x-breadcrumb :items="[['label' => 'Usuarios especiales']]" />

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Usuarios especiales</h2>
            <p class="mb-0">Consulta los usuarios especiales registrados en tu estacionamiento.</p>
        </div>
    </div>
    {{-- Role Filter Toolbar --}}
    <div class="btn-toolbar align-items-center mb-2">
        <label for="chart-period-select" class="text-gray-500 mb-0 me-2 fw-normal small">
            Filtrar por:
        </label>
        <form method="GET" action="{{ route('qpk.special-parking-users.index') }}" class="d-flex">
            <div class="input-group">
                <select name="role_id" class="form-select w-auto pe-5" onchange="this.form.submit()">
                    <option value="">Todos los roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->special_parking_role_id }}"
                            {{ $roleFilter == $role->special_parking_role_id ? 'selected' : '' }}>
                            {{ $role->type }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    {{-- Table Card --}}
    <div class="py-2">
        @if ($specialUsers->isNotEmpty())
            <div class="card card-body border-0 shadow table-wrapper table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-bottom text-uppercase rounded-start">Nombre del Usuario</th>
                            <th class="border-bottom text-uppercase">Teléfono</th>
                            <th class="border-bottom text-uppercase">Rol Asignado</th>
                            <th class="border-bottom text-uppercase rounded-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($specialUsers as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-gray-900 text-wrap">
                                            {{ $user->user->first_name }} {{ $user->user->last_name }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-normal text-gray-600">
                                        {{ $user->user->phone_number }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-wrap">
                                        {{ $user->specialParkingRole->type }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <x-icon name="action.more" size="xs" />
                                        </button>
                                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                            {{-- Delete Action --}}
                                            <button class="dropdown-item d-flex align-items-center text-danger"
                                                onclick="confirmDelete('{{ $user->special_parking_user_id }}')">
                                                <x-icon name="action.delete" size="xs" class="text-danger me-2" />
                                                Eliminar
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Hidden Delete Form --}}
                                    <form id="delete-form-{{ $user->special_parking_user_id }}"
                                        action="{{ route('qpk.special-parking-users.destroy', $user->special_parking_user_id) }}"
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
                    {{ $specialUsers->links('partials.pagination') }}
                    <div class="fw-normal small mt-4 mt-lg-0 ms-auto">
                        Mostrando <b>{{ $specialUsers->firstItem() }}</b> a <b>{{ $specialUsers->lastItem() }}</b> de
                        <b>{{ $specialUsers->total() }}</b> usuarios especiales
                    </div>
                </div>
            </div>
        @else
            <div class="card card-body border-0 shadow table-wrapper table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-bottom text-uppercase rounded-start">Nombre del Usuario</th>
                            <th class="border-bottom text-uppercase">Teléfono</th>
                            <th class="border-bottom text-uppercase">Rol Asignado</th>
                            <th class="border-bottom text-uppercase rounded-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center py-3 border-0">
                                <div class="mb-4">
                                    <span class="text-gray-200">
                                        <x-icon name="action.search" size="2x" />
                                    </span>
                                </div>
                                <h2 class="h5 fw-bold text-gray-800 mb-3">
                                    No se encontraron resultados.
                                </h2>
                                <p class="text-gray-500 mb-4">No hay usuarios registrados bajo el rol seleccionado.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="fw-normal small mt-4 mt-lg-0 ms-auto">
                    Mostrando <b> 0</b> a <b> 0</b> de
                    <b> 0</b> usuarios especiales
                </div>
        @endif
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

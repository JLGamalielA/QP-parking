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
     Description: Index view for Special Parking Users with Role Filter and Dropdown Actions.
--}}

@extends('layouts.app')

@section('title', 'Usuarios Especiales')

@section('content')
    {{-- Header Container --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-4">
        <div class="d-block mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('qpk.dashboard.index') }}"><x-icon name="nav.home" class="icon-xxs" /></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Usuarios Especiales</li>
                </ol>
            </nav>
        </div>

    </div>
    {{-- Role Filter Toolbar --}}
    <div class="btn-toolbar mb-3">
        <form method="GET" action="{{ route('qpk.special-parking-users.index') }}" class="d-flex">
            <div class="input-group">
                <select name="role_id" class="form-select border-start-0" onchange="this.form.submit()"
                    style="min-width: 200px; width: auto; max-width: 100%;">
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
    <div class="card shadow border-0 table-wrapper">
        @if ($specialUsers->isNotEmpty())
            <div class="card-body pb-0">
                <table class="table user-table align-items-center mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-bottom text-uppercase">Nombre del Usuario</th>
                            <th class="border-bottom text-uppercase">Teléfono</th>
                            <th class="border-bottom text-uppercase">Rol Asignado</th>
                            <th class="border-bottom text-uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($specialUsers as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-gray-900">
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
                                    {{ $user->specialParkingRole->type }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <x-icon name="action.more" class="icon-xs" />
                                        </button>
                                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">

                                            {{-- Edit Action --}}
                                            <a class="dropdown-item d-flex align-items-center"
                                                href="{{ route('qpk.special-parking-users.edit', $user->special_parking_user_id) }}">
                                                <x-icon name="action.edit" class="icon-xs text-gray-400 me-2" />
                                                Editar
                                            </a>

                                            {{-- Delete Action --}}
                                            <button class="dropdown-item d-flex align-items-center text-danger"
                                                onclick="confirmDelete('{{ $user->special_parking_user_id }}')">
                                                <x-icon name="action.delete" class="icon-xs text-danger me-2" />
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
            </div>

            {{-- Pagination --}}
            <div
                class="card-footer bg-white border-0 pt-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                {{ $specialUsers->links() }}
            </div>
        @else
            {{-- Empty State for Filter Results --}}
            <div class="card-body">
                <div class="text-center py-5">
                    <div class="mb-4"><span class="text-gray-200"><x-icon name="action.search" size="3x" /></span>
                    </div>
                    <h2 class="h5 fw-bold text-gray-800 mb-3">No se encontraron resultados.</h2>
                    <p class="text-gray-500 mb-4">No hay usuarios registrados bajo el rol seleccionado.</p>
                    <a href="{{ route('qpk.special-parking-users.index') }}" class="btn btn-sm btn-gray-800">
                        <x-icon name="action.view" class="me-2" /> Ver todos
                    </a>
                </div>
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

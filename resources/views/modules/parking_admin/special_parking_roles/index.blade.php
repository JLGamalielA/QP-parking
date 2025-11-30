{{--
    Company: CETAM
    Project: QPK
    File: index.blade.php
    Created on: 25/11/2025
    Created by: Daniel Yair Mendoza Alvarez
    Approved by: Daniel Yair Mendoza Alvarez
    
    Changelog:
    - ID: 1 | Modified on: 25/11/2025 | 
      Modified by: Daniel Yair Mendoza Alvarez | 
      Description: Standardized index view for Special Parking Roles. |
--}}

@extends('layouts.app')

@section('title', 'Tipos de Usuario')

@section('content')
    {{-- Header Container --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('qpk.dashboard.index') }}"><x-icon name="nav.home" class="icon-xxs" /></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tipos de Usuario</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-md-0">
            <a href="{{ route('qpk.special-parking-roles.create') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <x-icon name="action.create" class="icon-xs me-2" />
                Crear tipo de usuario
            </a>
        </div>
    </div>

    <div class="card shadow border-0 table-wrapper">
        <div class="card-body pb-0">
            <table class="table user-table align-items-center mb-0"> {{-- mb-0 ensures table has no bottom margin --}}
                <thead class="thead-light">
                    <tr>
                        <th class="border-bottom text-uppercase">Nombre</th>
                        <th class="border-bottom text-uppercase">Costo Comisión</th>
                        <th class="border-bottom text-uppercase">Periodo</th>
                        <th class="border-bottom text-uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td><span class="fw-bold">{{ $role->type }}</span></td>
                            <td>
                                ${{ $role->special_commission_value }}
                            </td>
                            <td>
                                <span class="small text-muted">
                                    {{ $role->special_commission_period == 3600
                                        ? 'Por hora'
                                        : ($role->special_commission_period == 86400
                                            ? 'Por día'
                                            : $role->special_commission_period . ' seg') }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        data-bs-boundary="viewport">
                                        <x-icon name="action.more" class="icon-xs" />
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('qpk.special-parking-roles.edit', $role) }}">
                                            <x-icon name="action.edit" class="icon-xs text-gray-400 me-2" />
                                            Editar
                                        </a>
                                        <button class="dropdown-item d-flex align-items-center text-danger"
                                            onclick="confirmDelete('{{ $role->special_parking_role_id }}')">
                                            <x-icon name="action.delete" class="icon-xs text-danger me-2" />
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                                <form id="delete-form-{{ $role->special_parking_role_id }}"
                                    action="{{ route('qpk.special-parking-roles.destroy', $role) }}" method="POST"
                                    class="d-none">
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
            {{ $roles->links() }}
        </div>

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

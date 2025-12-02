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
    <x-breadcrumb :items="[['label' => 'Tipos de Usuario']]" />

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Tipos de usuario</h2>
            <p class="mb-0">Consulta los tipos de usuarios registrados en tu estacionamiento.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <x-button type="primary" size="sm" :href="route('qpk.special-parking-roles.create')">
                <x-icon name="action.create" class="me-2" />
                Crear tipo de usuario
            </x-button>
        </div>
    </div>
    <div class="py-2">
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <table class="table">
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
                            <td>
                                <span class="fw-bold text-wrap">
                                    {{ $role->type }}
                                </span>
                            </td>
                            <td>
                                ${{ $role->special_commission_value }}
                            </td>
                            <td>
                                <span class="small text-muted">
                                    {{ $role->special_commission_period == 3600 ? 'Por hora' : 'Por día' }}
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
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('qpk.special-parking-roles.edit', $role) }}">
                                            <x-icon name="action.edit" size="xs" class="text-gray-400 me-2" />
                                            Editar
                                        </a>
                                        <button class="dropdown-item d-flex align-items-center text-danger"
                                            onclick="confirmDelete('{{ $role->special_parking_role_id }}')">
                                            <x-icon name="action.delete" size="xs" class="text-danger me-2" />
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
            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                {{ $roles->links('partials.pagination') }}
                <div class="fw-normal small mt-4 mt-lg-0">
                    Mostrando <b>{{ $roles->firstItem() }}</b> al <b>{{ $roles->lastItem() }}</b> de
                    <b>{{ $roles->total() }}</b> tipos de usuarios
                </div>
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

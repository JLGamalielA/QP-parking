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
     Description: Main index view for Parking Entries. |
   - ID: 2 | Modified on: 26/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Moved activation button into dropdown menu with divider styling. |
--}}

@extends('layouts.app')

@section('title', 'Lectores')

@section('content')
    {{-- Header Container --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('qpk.dashboard.index') }}"><x-icon name="home" class="icon-xxs" /></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Lectores</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-md-0">
            <a href="{{ route('qpk.parking-entries.create') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <x-icon name="add" class="icon-xs me-2" />
                Crear lector
            </a>
        </div>
    </div>

    <div class="card shadow border-0 table-wrapper">
        <div class="card-body pb-0">
            <table class="table user-table align-items-center mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="border-bottom text-uppercase">Nombre de Lector</th>
                        <th class="border-bottom text-uppercase">Tipo</th>
                        <th class="border-bottom text-uppercase">Estado</th>

                        {{-- Combined Action Column --}}
                        <th class="border-bottom text-uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entries as $entry)
                        <tr>
                            <td><span class="fw-bold">{{ $entry->name }}</span></td>
                            <td>
                                {{ $entry->is_entry ? 'Entrada' : 'Salida' }}
                            </td>
                            <td>
                                <span class="fw-bold text-danger reader-status-text"
                                    data-entry-id="{{ $entry->parking_entry_id }}">
                                    Inactivo
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        data-bs-boundary="viewport">
                                        <x-icon name="ellipsis" class="icon-xs" />
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        {{-- Edit Action --}}
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('qpk.parking-entries.edit', $entry->parking_entry_id) }}">
                                            <x-icon name="edit" class="icon-xs text-gray-400 me-2" />
                                            Editar
                                        </a>

                                        {{-- Delete Action --}}
                                        <button class="dropdown-item d-flex align-items-center text-danger"
                                            onclick="confirmDelete('{{ $entry->parking_entry_id }}')">
                                            <x-icon name="trash" class="icon-xs text-danger me-2" />
                                            Eliminar
                                        </button>

                                        {{-- Divider --}}
                                        <div role="separator" class="dropdown-divider my-1"></div>

                                        {{-- Activation Action (Moved Here) --}}
                                        {{-- IMPORTANT: Class 'btn-activate-reader' is used by JS --}}
                                        <button type="button"
                                            class="dropdown-item d-flex align-items-center text-success fw-bold btn-activate-reader"
                                            data-store-url="{{ route('qpk.active-user-qr-scans.store') }}"
                                            data-parking-id="{{ $parking->parking_id }}"
                                            data-entry-id="{{ $entry->parking_entry_id }}">
                                            {{-- Using 'key' icon or 'qrcode' --}}
                                            <x-icon name="key" class="icon-xs text-success me-2" />
                                            <span>Activar</span>
                                        </button>
                                    </div>
                                </div>
                                <form id="delete-form-{{ $entry->parking_entry_id }}"
                                    action="{{ route('qpk.parking-entries.destroy', $entry->parking_entry_id) }}"
                                    method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Output area for scanner feedback --}}
            <div id="qr-output" class="mt-3 px-3 pb-3 text-center fw-bold"></div>
        </div>

        <div
            class="card-footer bg-white border-0 pt-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            {{ $entries->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/alert-handler.js') }}"></script>
    <script src="{{ mix('js/modules/parking/qr-reader.js') }}"></script>
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

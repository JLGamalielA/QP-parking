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
     Description: Main index view for Parking Entries

   - ID: 2 | Date: 26/11/2025 
     Modified by: Daniel Yair Mendoza Alvarez
     Description: Moved activation button into dropdown menu with divider styling
--}}

@extends('layouts.app')

@section('title', 'Lectores')

@section('content')
    <x-breadcrumb :items="[['label' => 'Lectores']]" />
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Lectores</h2>
            <p class="mb-0">Consulta los lectores de tu estacionamiento</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <x-button type="primary" :href="route('qpk.parking-entries.create')">
                <x-icon name="action.create" class="me-2 text-white" />
                Crear lector
            </x-button>
        </div>
    </div>

    <div class="py-2">
        <div class="card card-body border-0 shadow table-wrapper">
            <table class="table">
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
                    {{-- 
                      Display a message when there are no entries
                      This loop handles that case by not rendering any rows
                     --}}
                    @foreach ($entries as $entry)
                        <tr>
                            <td>
                                <span class="fw-bold text-wrap">
                                    {{ $entry->name }}
                                </span>
                            </td>
                            <td>
                                {{ $entry->is_entry ? 'Entrada' : 'Salida' }}
                            </td>
                            <td>
                                <span class="fw-bold text-warning reader-status-text"
                                    data-entry-id="{{ $entry->parking_entry_id }}">
                                    Inactivo
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        data-bs-boundary="viewport">
                                        <x-icon name="action.more" size="xs" />
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        {{-- Edit Action --}}
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('qpk.parking-entries.edit', $entry->parking_entry_id) }}">
                                            <x-icon name="action.edit" size="xs" class="text-gray-400 me-2" />
                                            Editar
                                        </a>

                                        {{-- Delete Action --}}
                                        @if ($entry->active_user_qr_scans_count == 0 && $entry->history_as_entry_count == 0 &&
                                                $entry->history_as_exit_count == 0)
                                            <button class="dropdown-item d-flex align-items-center text-danger"
                                                onclick="confirmDelete('{{ $entry->parking_entry_id }}')">
                                                <x-icon name="action.delete" size="xs" class="text-danger me-2" />
                                                Eliminar
                                            </button>
                                        @endif
                                        {{-- Divider --}}
                                        <div role="separator" class="dropdown-divider my-1"></div>

                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('qpk.parking-entries.manual-access.create', $entry->parking_entry_id) }}">
                                            <x-icon name="msg.phone" size="xs" class="me-2 text-gray-400" />
                                            Registro por número de teléfono
                                        </a>

                                        <button type="button"
                                            class="dropdown-item d-flex align-items-center text-success fw-bold btn-activate-reader"
                                            data-store-url="{{ route('qpk.active-user-qr-scans.store') }}"
                                            data-parking-id="{{ $parking->parking_id }}"
                                            data-entry-id="{{ $entry->parking_entry_id }}">
                                            {{-- Using 'key' icon or 'qrcode' --}}
                                            <x-icon name="access.key" size="xs" class="text-success me-2" />
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

            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                {{ $entries->links('partials.pagination') }}
                <div class="fw-normal small mt-4 mt-lg-0 ms-auto">
                    Mostrando <b>{{ $entries->firstItem() }}</b> a <b>{{ $entries->lastItem() }}</b> de
                    <b>{{ $entries->total() }}</b> lectores
                </div>
            </div>
            {{-- Output area for scanner feedback --}}
            <div id="qr-output" class="text-center fw-bold"></div>
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

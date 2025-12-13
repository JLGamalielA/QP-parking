{{--
   Company: CETAM
   Project: QPK
   File: special-user-applications-table.blade.php
   Created on: 12/12/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 12/12/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Special User Applications Table component view. |
--}}

<div>
    {{-- Search Bar --}}
    <div class="btn-toolbar mb-2">
        <div class="input-group me-2 me-lg-3">
            <span class="input-group-text">
                <x-icon name="action.search" size="xs" />
            </span>
            <input wire:model.live.debounce.100ms="search" wire:keydown.enter="$refresh" type="text"
                class="form-control search-input" placeholder="Buscar por teléfono." maxlength="10" autocomplete="off"
                inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
    </div>

    {{-- Content Wrapper --}}
    <div class="py-2">
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th class="border-bottom text-uppercase rounded-start">Nombre del usuario</th>
                        <th class="border-bottom text-uppercase">Teléfono</th>
                        <th class="border-bottom text-uppercase">Tipo de usuario solicitado</th>
                        <th class="border-bottom text-uppercase rounded-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        <tr>
                            <td>
                                <span class="fw-bold text-gray-900 text-wrap">
                                    {{ $app->user->first_name }} {{ $app->user->last_name }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-normal text-gray-600">
                                    {{ $app->user->phone_number }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-normal text-gray-600 text-wrap">
                                    {{ $app->specialParkingRole->type }}
                                </span>
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
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 border-0">
                                <div class="mb-4">
                                    <span class="text-gray-200">
                                        @if ($search)
                                            <x-icon name="action.search" size="2x" />
                                        @else
                                            <x-icon name="msg.inbox" size="2x" />
                                        @endif
                                    </span>
                                </div>
                                <h2 class="h5 fw-bold text-gray-800 mb-3">
                                    @if ($search)
                                        No se encontraron resultados.
                                    @else
                                        No hay solicitudes pendientes.
                                    @endif
                                </h2>
                                <p class="text-gray-500 mb-4">
                                    @if ($search)
                                        El número <strong>"{{ $search }}"</strong> no coincide con ninguna
                                        solicitud.
                                    @else
                                        No hay solicitudes de usuarios especiales en este momento.
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Footer Pagination --}}
            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                @if ($applications->hasPages())
                    {{ $applications->links('partials.pagination') }}
                @endif
                <div class="fw-normal small mt-4 mt-lg-0 ms-auto">
                    Mostrando <b>{{ $applications->firstItem() ?? 0 }}</b> al
                    <b>{{ $applications->lastItem() ?? 0 }}</b> de
                    <b>{{ $applications->total() }}</b> solicitudes
                </div>
            </div>
        </div>
    </div>
</div>

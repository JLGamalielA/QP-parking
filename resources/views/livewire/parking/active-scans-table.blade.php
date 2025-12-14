{{--
   Company: CETAM
   Project: QPK
   File: active-scans-table.blade.php
   Created on: 12/12/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Date: 12/12/2025
     Modified by: Daniel Yair Mendoza Alvarez
     Description: Active Scans Table component view
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
                        <th class="border-bottom text-uppercase rounded-start">Nombre de la Entrada</th>
                        <th class="border-bottom text-uppercase">Nombre del Usuario</th>
                        <th class="border-bottom text-uppercase">Teléfono</th>
                        <th class="border-bottom text-uppercase rounded-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 
                      Display paginated active scans with their details.
                      This loop handles the case when there are no active scans to display.
                     --}}
                    @forelse ($activeEntries as $scan)
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
                                            onclick="generateExitQrDirectly('{{ route('qpk.active-user-qr-scans.destroy', $scan->active_user_qr_scan_id) }}')">
                                            <x-icon name="action.scan" size="xs" class=" me-2 text-gray-400" />
                                            Generar qr de salida
                                        </button>
                                    </div>
                                </div>
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
                                            <x-icon name="action.flag" size="2x" />
                                        @endif
                                    </span>
                                </div>
                                <h2 class="h5 fw-bold text-gray-800 mb-3">
                                    @if ($search)
                                        No se encontraron resultados.
                                    @else
                                        El estacionamiento está vacío.
                                    @endif
                                </h2>
                                <p class="text-gray-500 mb-4">
                                    @if ($search)
                                        No hay coincidencias para "<strong>{{ $search }}</strong>".
                                    @else
                                        No hay usuarios actualmente dentro de las instalaciones.
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Footer --}}
            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                @if ($activeEntries->hasPages())
                    {{ $activeEntries->links('livewire.livewire-pagination') }}
                @endif
                <div class="fw-normal small mt-4 mt-lg-0 ms-auto">
                    Mostrando <b>{{ $activeEntries->firstItem() ?? 0 }}</b> a
                    <b>{{ $activeEntries->lastItem() ?? 0 }}</b> de
                    <b>{{ $activeEntries->total() }}</b> entradas activas
                </div>
            </div>
        </div>
    </div>
</div>

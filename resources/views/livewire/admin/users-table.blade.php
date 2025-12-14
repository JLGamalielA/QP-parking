{{--
   Company: CETAM
   Project: QPK
   File: users-table.blade.php
   Created on: 03/12/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Date: 03/12/2025
     Modified by: Daniel Yair Mendoza Alvarez
     Description: Users table view with filters and pagination
--}}

<div>
    {{-- Filter Toolbar --}}
    <div class="btn-toolbar align-items-center mb-2">
        <div class="d-flex flex-wrap align-items-center gap-3 mb-2 w-100">

            {{-- 1. Search Input --}}
            <div class="input-group w-auto">
                <span class="input-group-text"><x-icon name="action.search" /></span>
                <input wire:model.live.debounce.300ms="search" wire:keydown.enter="$refresh" type="text"
                    class="form-control search-input" placeholder="Buscar por teléfono." maxlength="10" autocomplete="off"
                    inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>

            {{-- 2. Platform Filter --}}
            <label class="text-gray-500 mb-0 me-2 fw-normal small align-self-center">
                Filtrar por plataforma:
            </label>
            <select wire:model.live="platform" class="form-select w-auto text-gray-600 pe-5 me-2">
                <option value="">Todas</option>
                <option value="web">Web</option>
                <option value="mobile">Móvil</option>
            </select>

            {{-- 3. Subscription Status Filter --}}
            <label class="text-gray-500 mb-0 me-2 fw-normal small align-self-center">
                Filtrar por estado:
            </label>
            <select wire:model.live="status" class="form-select w-auto text-gray-600 pe-5">
                <option value="">Todos los estados</option>
                <option value="active">Suscripción Activa</option>
                <option value="inactive">Suscripción Inactiva</option>
            </select>
            <button wire:click="clearFilters"
                class="btn btn-sm btn-secondary text-white d-flex align-items-center ms-auto">
                <x-icon name="action.refresh" class="me-2" size="xs" />
                Limpiar filtros
            </button>
        </div>
    </div>

    {{-- Table Content --}}
    <div class="py-2">
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <table class="table rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-bottom text-uppercase rounded-start">Usuario</th>
                        <th class="border-bottom text-uppercase">Teléfono</th>
                        <th class="border-bottom text-uppercase">Plataforma</th>
                        <th class="border-bottom text-uppercase">Suscripción</th>
                        <th class="border-bottom text-uppercase">Estado</th>
                        <th class="border-bottom text-uppercase rounded-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 
                      Display paginated users with their details.
                      This loop handles the case when there are no users to display.
                     --}}
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-block">
                                        <span class="fw-bold text-gray-900 text-wrap">
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </span>
                                        <div class="small text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-normal text-gray-600">
                                    {{ $user->phone_number }}
                                </span>
                            </td>
                            <td>
                                {{ $user->platform == 'web' ? 'Web' : 'Móvil' }}
                            </td>
                            <td>
                                <span class="fw-normal text-gray-600">
                                    {{ $user->displayPlanName ?? 'N/A' }}
                                </span>
                                @if ($user->subscription && $user->subscription->end_date)
                                    <div class="small text-gray-400">
                                        Vence:
                                        {{ \Carbon\Carbon::parse($user->subscription->end_date)->format('d/m/Y') }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if ($user->isSubscriptionActive ?? false)
                                    <span class="text-success">Activa</span>
                                @else
                                    <span class="text-warning">Inactiva</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <x-icon name="action.more" size="xs" />
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>

                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        <button class="dropdown-item d-flex align-items-center text-warning"
                                            onclick="confirmDeactivation('{{ $user->user_id }}')">
                                            <x-icon name="nav.close" size="xs" class="text-warning me-2" />
                                            Inactivar cuenta
                                        </button>
                                    </div>
                                </div>

                                <form id="deactivate-form-{{ $user->user_id }}"
                                    action="{{ route('qpk.subscriptions.users.deactivate', $user->user_id) }}"
                                    method="POST" class="d-none">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 border-0">
                                <div class="mb-4">
                                    <span class="text-gray-200">
                                        @if ($search || $platform || $status)
                                            <x-icon name="action.search" size="2x" />
                                        @else
                                            <x-icon name="user.group" size="2x" />
                                        @endif
                                    </span>
                                </div>
                                <h2 class="h5 fw-bold text-gray-800 mb-3">
                                    @if ($search || $platform || $status)
                                        No se encontraron resultados.
                                    @else
                                        No hay usuarios registrados.
                                    @endif
                                </h2>
                                <p class="text-gray-500 mb-4">
                                    @if ($search)
                                        El número <strong>"{{ $search }}"</strong> no coincide con ningún
                                        usuario.
                                    @else
                                        No hay usuarios que coincidan con los filtros seleccionados.
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
                @if ($users->hasPages())
                    {{ $users->links('livewire.livewire-pagination') }}
                @endif
                <div class="fw-normal small mt-4 mt-lg-0 ms-auto">
                    Mostrando <b>{{ $users->firstItem() ?? 0 }}</b> a <b>{{ $users->lastItem() ?? 0 }}</b> de
                    <b>{{ $users->total() }}</b> usuarios
                </div>
            </div>
        </div>
    </div>
</div>

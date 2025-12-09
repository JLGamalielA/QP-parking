{{--
   Company: CETAM
   Project: QPK
   File: index.blade.php
   Created on: 03/12/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 03/12/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Index view to consult all the users in the system. |
--}}

@extends('layouts.admin')

@section('title', 'Inicio')

@section('content')
    <x-admin-breadcrumb :items="[['label' => 'Inicio']]" />

    {{-- Header Section --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Inicio</h2>
            <p class="mb-0">Consulta general de usuarios registrados en el sistema.</p>
        </div>
    </div>

    {{-- Filter Toolbar --}}
    <div class="btn-toolbar align-items-center mb-2">
        <div class="d-flex flex-wrap align-items-center gap-2 w-100">
            {{-- Form wrapper for all filters --}}
            <form method="GET" action="{{ route('qpk.admin-dashboard.index') }}" class="d-flex flex-wrap gap-2 grow">
                {{-- 3. Search Input (Aligned to right or flexible) --}}
                <div class="input-group ms-auto me-2">
                    <span class="input-group-text"><x-icon name="action.search" /></span>
                    <input type="text" name="search" class="form-control search-input"
                        placeholder="Buscar por teléfono." value="{{ $search ?? '' }}" maxlength="10" autocomplete="off">
                </div>
                {{-- 1. Platform Filter --}}
                <label class="text-gray-500 mb-0 me-2 fw-normal small align-self-center">
                    Filtrar por plataforma:
                </label>
                <select name="platform" class="form-select w-auto text-gray-600 pe-5 me-2" onchange="this.form.submit()">
                    <option value="">Todas</option>
                    <option value="web" {{ $platform == 'web' ? 'selected' : '' }}>Web</option>
                    <option value="mobile" {{ $platform == 'mobile' ? 'selected' : '' }}>Móvil</option>
                </select>

                {{-- 2. Subscription Status Filter --}}
                <label class="text-gray-500 mb-0 me-2 fw-normal small align-self-center">
                    Filtrar por estado:
                </label>
                <select name="status" class="form-select w-auto text-gray-600 pe-5" onchange="this.form.submit()">
                    <option value="">Todos los estados</option>
                    <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Suscripción Activa</option>
                    <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Suscripción Inactiva</option>
                </select>

            </form>
        </div>
    </div>

    {{-- Table Content --}}
    <div class="py-2">
        @if ($users->isNotEmpty())
            <div class="card card-body border-0 shadow table-wrapper table-responsive">
                <table class="table rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-bottom text-uppercase">Usuario</th>
                            <th class="border-bottom text-uppercase">Teléfono</th>
                            <th class="border-bottom text-uppercase">Plataforma</th>
                            <th class="border-bottom text-uppercase">Suscripción</th>
                            <th class="border-bottom text-uppercase">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
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
                                    @if ($user->platform == 'web')
                                        Web
                                    @else
                                        Móvil
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-normal text-gray-600">
                                        {{ $user->displayPlanName }}
                                    </span>
                                    @if ($user->subscriptionEndDate)
                                        <div class="small text-gray-400">
                                            Vence:
                                            {{ $user->subscriptionEndDate }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->isSubscriptionActive)
                                        <span class="text-success">Activa</span>
                                    @else
                                        <span class="text-danger">Inactiva</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination Footer --}}
                <div
                    class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                    {{ $users->links('partials.pagination') }}
                    <div class="fw-normal small mt-4 mt-lg-0">
                        Mostrando <b>{{ $users->firstItem() }}</b> al <b>{{ $users->lastItem() }}</b> de
                        <b>{{ $users->total() }}</b> usuarios
                    </div>
                </div>
            </div>
        @else
            {{-- Empty State --}}
            <x-card>
                <div class="card-body">
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <span class="text-gray-200">
                                <x-icon name="action.search" size="2x" />
                            </span>
                        </div>
                        <h2 class="h5 fw-bold text-gray-800 mb-3">No se encontraron resultados.</h2>
                        <p class="text-gray-500 mb-4">
                            No hay usuarios que coincidan con los filtros seleccionados.
                        </p>
                        {{-- Reset Filter Button --}}
                        <a href="{{ route('qpk.admin-dashboard.index') }}" class="btn btn-sm btn-gray-800">
                            <x-icon name="action.view" class="me-2" />
                            Ver todos los usuarios
                        </a>
                    </div>
                </div>
            </x-card>
        @endif
    </div>
@endsection

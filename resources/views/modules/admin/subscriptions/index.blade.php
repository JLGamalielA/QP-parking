{{--
   Company: CETAM
   Project: QPK
   File: index.blade.php
   Created on: 04/12/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 04/12/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Index view to consult all the subscriptions in the system. |
--}}

@extends('layouts.admin')

@section('title', 'Subscripciones')

@section('content')
    <x-admin-breadcrumb :items="[['label' => 'Subscripciones']]" />

    {{-- Header Section --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Subscripciones</h2>
            <p class="mb-0">Administración de planes disponibles para los usuarios.</p>
        </div>
    </div>

    {{-- Table Content --}}
    <div class="py-2">
        <div class="card card-body border-0 shadow table-wrapper table-responsive rounded overflow-hidden">
            <table class="table rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-bottom text-uppercase rounded-start">Nombre del Plan</th>
                        <th class="border-bottom text-uppercase">Precio</th>
                        <th class="border-bottom text-uppercase">Duración</th>
                        <th class="border-bottom text-uppercase">Beneficios Incluidos</th>
                        <th class="border-bottom text-uppercase rounded-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscriptions as $plan)
                        <tr>
                            <td>
                                <span class="fw-bold text-gray-900">
                                    {{ $plan->name }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-normal text-gray-600">
                                    {{ $plan->formattedPrice }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-normal text-gray-600">
                                    {{ $plan->displayDuration }}
                                </span>
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0 small text-gray-600">
                                    @foreach ($plan->benefits as $benefit)
                                        <li class="d-flex align-items-start mb-1 text-wrap">
                                            {{ $benefit->benefit }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <x-icon name="action.more" size="xs" />
                                    </button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('qpk.subscriptions.edit', $plan->subscription_id) }}">
                                            <x-icon name="action.edit" size="xs" class="text-gray-400 me-2" />
                                            Editar
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="fw-normal small mt-4 mt-lg-0 ms-auto">
                Mostrando <b> 1 </b> al <b> 2 </b> de <b> 2 </b> subscripciones.
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

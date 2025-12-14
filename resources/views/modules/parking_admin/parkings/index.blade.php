{{--
    Company: CETAM
    Project: QPK
    File: index.blade.php
    Created on: 22/11/2025
    Created by: Daniel Yair Mendoza Alvarez
    Approved by: Daniel Yair Mendoza Alvarez

    Changelog:
    - ID: 1 | Modified on: 22/11/2025 |
      Modified by: Daniel Yair Mendoza Alvarez |
      Description: Parking index view using custom QPK Blade components. |

   - ID: 2 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Refined button styles (white icons on colored buttons) and table headers to match Section 8 standards strictly. |

    - ID: 3 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Removed create button (1-to-1 relation enforcement) and validated table styles. |
--}}

@extends('layouts.app')

@section('title', 'Estacionamientos')

@section('content')
    <x-breadcrumb :items="[['label' => 'Estacionamiento']]" />

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Estacionamiento</h2>
            <p class="mb-0"> Tu estacionamiento en Qparking. </p>
        </div>
    </div>


    <div class="py-2">
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th class="border-bottom text-uppercase rounded-start">Nombre</th>
                        <th class="border-bottom text-uppercase">Tipo de estacionamiento</th>
                        <th class="border-bottom text-uppercase rounded-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="fw-bold text-wrap">
                                {{ $parking->name }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-normal">{{ $parking->display_type }}</span>
                        </td>
                        {{-- Actions Column --}}
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <x-icon name="action.more" size="xs" />
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>

                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                    {{-- Edit Action --}}
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route('qpk.parkings.edit', $parking) }}">
                                        <x-icon name="action.edit" size="xs" class="text-gray-400 me-2" />
                                        Editar
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                <div class="fw-normal small mt-4 mt-lg-0 ms-auto">
                    Mostrando <b> 1 </b> a <b> 1 </b> de <b> 1 </b> estacionamiento
                </div>
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

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
      Changelog:
   - ID: 2 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Refined button styles (white icons on colored buttons) and table headers to match Section 8 standards strictly. |

    - ID: 3 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Removed create button (1-to-1 relation enforcement) and validated table styles against Manual Figure 41. |
--}}

@extends('layouts.app')

@section('title', 'Estacionamientos')

@section('content')
    <div class="py-2>

        {{-- Breadcrumb navigation --}}
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="{{ route('qpk.dashboard.index') }}">
                    <x-icon name="nav.home" class="icon-xs" />
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Estacionamiento') }}</li>
        </ol>
        </nav>

        <div class="card card-body shadow border-0 table-wrapper">
            <table class="table user-table align-items-center">
                <thead class="thead-light">
                    <tr>
                        <th class="border-bottom text-uppercase">{{ __('Nombre') }}</th>
                        <th class="border-bottom text-uppercase">{{ __('Dirección') }}</th>
                        <th class="border-bottom text-uppercase">{{ __('Comisión') }}</th>
                        <th class="border-bottom text-uppercase">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($parking)
                        <tr>
                            <td><span class="fw-normal">{{ $parking->name }}</span></td>
                            <td>
                                <span class="fw-normal text-wrap" style="max-width: 250px;" title="{{ $parking->address }}">
                                    {{ Str::limit($parking->address, 40) }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold">${{ $parking->commission_value }}</span>
                                <span class="small text-muted">/ {{ $parking->period_label }}</span>
                            </td>

                            {{-- Actions Column --}}
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        data-bs-boundary="viewport">

                                        <x-icon name="action.more" class="icon-xs" /> {{-- Updated Component Name --}}
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>

                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        {{-- Edit Action --}}
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('qpk.parkings.edit', $parking) }}">
                                            <x-icon name="action.edit" class="icon-xs text-gray-400 me-2" />
                                            {{ __('Editar') }}
                                        </a>
                                        {{-- Delete Action --}}
                                        <button class="dropdown-item d-flex align-items-center text-danger"
                                            onclick="confirmDelete('{{ $parking->parking_id }}')">
                                            <x-icon name="action.delete" class="icon-xs text-danger me-2" />
                                            {{ __('Eliminar') }}
                                        </button>
                                    </div>
                                </div>
                                <form id="delete-form-{{ $parking->parking_id }}"
                                    action="{{ route('qpk.parkings.destroy', $parking) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
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

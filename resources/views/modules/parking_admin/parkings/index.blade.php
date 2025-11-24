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
    <div class="py-4">

        {{-- Breadcrumb navigation --}}
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.dashboard.index') }}">
                        <x-qpk-icon name="home" class="icon-xxs" />
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Estacionamiento') }}</li>
            </ol>
        </nav>

        <x-qpk-card>
            <x-slot name="titleSlot">
                {{ __('Administración de Estacionamientos') }}
            </x-slot>

            {{-- 
               Note: 'actions' slot removed. 
               Since a user can only have one parking, the creation button 
               is moved to the 'no-elements' view.
            --}}

            <x-qpk-table>
                <x-slot name="head">
                    {{-- Headers Uppercase as per Manual Figure 41 --}}
                    <tr>
                        <th class="border-bottom text-uppercase">{{ __('Nombre') }}</th>
                        <th class="border-bottom text-uppercase">{{ __('Dirección') }}</th>
                        <th class="border-bottom text-uppercase">{{ __('Comisión') }}</th>
                        <th class="border-bottom text-uppercase text-end">{{ __('Acciones') }}</th>
                    </tr>
                </x-slot>

                <x-slot name="body">
                    @if ($parking)
                        <tr>
                            <td><span class="fw-normal">{{ $parking->name }}</span></td>
                            <td>
                                <span class="fw-normal text-wrap" style="max-width: 250px;" title="{{ $parking->address }}">
                                    {{ Str::limit($parking->address, 40) }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-success">${{ $parking->commission_value }}</span>
                                <span class="small text-muted">/ {{ $parking->period_label }}</span>
                            </td>
                            <td class="text-end align-middle">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- <div class="btn-group"> --}}
                                    {{-- Edit Button (Secondary per Manual logic for non-primary actions) --}}
                                    <x-qpk-button type="secondary" size="sm" :href="route('qpk.parkings.edit', $parking)"
                                        title="{{ __('Editar') }}" aria-label="{{ __('Editar') }}">
                                        <x-qpk-icon name="edit" class="icon-xs text-white" />
                                    </x-qpk-button>

                                    {{-- Delete Button with SweetAlert2 Confirmation --}}
                                    <button type="button"
                                        class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center"
                                        title="{{ __('Eliminar') }}" onclick="confirmDelete('{{ $parking->parking_id }}')"
                                        aria-label="{{ __('Eliminar') }}">
                                        <x-qpk-icon name="trash" class="icon-xs text-white" />
                                    </button>

                                    {{-- Hidden Form for Deletion --}}
                                    <form id="delete-form-{{ $parking->parking_id }}"
                                        action="{{ route('qpk.parkings.destroy', $parking) }}" method="POST"
                                        class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endif
                </x-slot>
            </x-qpk-table>

        </x-qpk-card>
    </div>
@endsection
@section('scripts')
    {{-- SweetAlert2 Logic based on Session --}}
    @if (session('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '{{ session('swal')['icon'] }}',
                    title: '{{ session('swal')['title'] }}',
                    text: '{{ session('swal')['text'] }}',
                    confirmButtonColor: '#1F2937', // Primary Color from Manual
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>
    @endif
@endsection

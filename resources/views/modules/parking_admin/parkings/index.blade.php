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

        {{-- Alerts --}}
        @if (session('swal'))
            <div class="alert alert-success my-3" role="alert">
                {{ session('swal')['text'] }}
            </div>
        @endif

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
                        <th class="border-bottom text-uppercase">#</th>
                        <th class="border-bottom text-uppercase">{{ __('Nombre') }}</th>
                        <th class="border-bottom text-uppercase">{{ __('Dirección') }}</th>
                        <th class="border-bottom text-uppercase">{{ __('Comisión') }}</th>
                        <th class="border-bottom text-uppercase text-end">{{ __('Acciones') }}</th>
                    </tr>
                </x-slot>

                <x-slot name="body">
                    @if ($parking)
                        <tr>
                            <td><span class="fw-bold">{{ $parking->parking_id }}</span></td>
                            <td><span class="fw-normal">{{ $parking->name }}</span></td>
                            <td>
                                <span class="fw-normal text-wrap" style="max-width: 250px;"
                                    title="{{ $parking->address }}">
                                    {{ Str::limit($parking->address, 40) }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-success">${{ $parking->commission_value }}</span>
                                <span class="small text-muted">/ {{ $parking->commission_period }}min</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    {{-- Edit Button --}}
                                    <x-qpk-button type="info" size="sm" :href="route('qpk.parkings.edit', $parking)"
                                        title="{{ __('Editar') }}">
                                        <x-qpk-icon name="edit" class="icon-xs text-white" />
                                    </x-qpk-button>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('qpk.parkings.destroy', $parking) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('{{ __('¿Estás seguro?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <x-qpk-button type="danger" size="sm" submit title="{{ __('Eliminar') }}">
                                            <x-qpk-icon name="trash" class="icon-xs text-white" />
                                        </x-qpk-button>
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

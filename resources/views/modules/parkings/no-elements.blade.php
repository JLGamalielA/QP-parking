{{--
   Company: CETAM
   Project: QPK
   File: no-elements.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Empty state view for Parkings module using standardized cards, typography, and action buttons. |
--}}

@extends('layouts.app')

@section('title', 'Estacionamientos')

@section('content')
    <div class="py-4">

        {{-- 
            Breadcrumb Navigation
            Replicates the "Panel > Parking" structure using the standard component.
        --}}
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

        {{-- 
            Main Container
            Uses x-qpk-card to maintain consistency with the rest of the system.
        --}}
        <div class="row justify-content-center mt-4">
            <div class="col-12">
                <x-qpk-card>
                    <div class="text-center py-5">

                        {{-- 
                            Optional: Visual Icon (Recommended for UX) 
                            Uncomment this block if a visual cue is needed.
                        --}}
                        
                        <div class="mb-4">
                            <span class="text-gray-200">
                                <x-qpk-icon name="mapMarker" size="3x" />
                            </span>
                        </div> 
                       

                        {{-- Main Title (Typography h5/h4 based on Section 8.2.5) --}}
                        <h2 class="h5 fw-bold text-gray-800 mb-3">
                            {{ __('Aún no se han registrado estacionamientos en el sistema.') }}
                        </h2>

                        {{-- Helper Text (Microcopy Section 7.6: Clear and Empathetic) --}}
                        <p class="text-gray-500 mb-4">
                            {{ __('Cuando crees tu estacionamiento, aparecerá en este apartado.') }}
                        </p>

                        {{-- 
                            Action Button
                            Type: Primary (Main action)
                            Text: Imperative verb "Create" (Section 7.6)
                        --}}
                        <x-qpk-button type="primary" :href="route('qpk.parkings.create')">
                            <x-qpk-icon name="add" class="icon-xs me-2 text-white" />
                            {{ __('Crear estacionamiento') }}
                        </x-qpk-button>
                    </div>
                </x-qpk-card>
            </div>
        </div>
    </div>
@endsection

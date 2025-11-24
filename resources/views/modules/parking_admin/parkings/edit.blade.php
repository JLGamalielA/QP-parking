{{--
    Company: CETAM
    Project: QPK
    File: edit.blade.php
    Created on: 24/11/2025
    Created by: Daniel Yair Mendoza Alvarez
    Approved by: Daniel Yair Mendoza Alvarez

    Changelog:
    - ID: 1 | Modified on: 24/11/2025 |
      Modified by: Daniel Yair Mendoza Alvarez |
      Description: Parking edit form. Implements data pre-filling logic favoring 'old' input over DB values for validation persistence. |
--}}

@extends('layouts.app')

@section('title', 'Editar Estacionamiento')

@push('css')
    {{-- Leaflet CSS (Now correctly loaded via stack) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        /* Fix map container height */
        #map {
            height: 400px;
            width: 100%;
            z-index: 1;
        }
    </style>
@endpush

@section('content')
    <div class="py-4">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block mb-3">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.dashboard.index') }}"><x-qpk-icon name="home" class="icon-xxs" /></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.parkings.index') }}">{{ __('Estacionamientos') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Editar') }}</li>
            </ol>
        </nav>

        <form action="{{ route('qpk.parkings.update', $parking->parking_id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Method spoofing for Update --}}

            {{-- SECTION 1: General Information & Location (Stacked) --}}
            <div class="row mb-4">
                <div class="col-12">
                    <x-qpk-card title="Información del Estacionamiento">

                        {{-- Row 1: Basic Details --}}
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-12 col-md-6 mb-3">
                                <label for="name" class="form-label">{{ __('Nombre del Estacionamiento') }}</label>
                                <input type="text" maxlength="100"
                                    class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                    {{-- Logic: Use old input if available, otherwise use DB value --}} value="{{ old('name', $parking->name) }}"
                                    placeholder="Ingresa el nombre" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div class="col-12 col-md-6 mb-3">
                                <label for="address" class="form-label">{{ __('Dirección') }}</label>
                                <input type="text" maxlength="255"
                                    class="form-control @error('address') is-invalid @enderror" id="address"
                                    name="address" value="{{ old('address', $parking->address) }}"
                                    placeholder="Calle, Número, Colonia" required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Row 2: Financial Details --}}
                        <div class="row mb-2">
                            {{-- Period --}}
                            <div class="col-12 col-md-6 mb-3">
                                <label for="commission_period" class="form-label">{{ __('Periodo de Pago') }}</label>
                                <select class="form-select @error('commission_period') is-invalid @enderror"
                                    id="commission_period" name="commission_period" required>
                                    <option value="" disabled>{{ __('Selecciona') }}</option>

                                    @php
                                        $currentPeriod = old('commission_period', $parking->commission_period);
                                    @endphp

                                    <option value="3600" {{ $currentPeriod == '3600' ? 'selected' : '' }}>
                                        Hora</option>
                                    <option value="86400" {{ $currentPeriod == '86400' ? 'selected' : '' }}>
                                        Día</option>
                                </select>
                                @error('commission_period')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Cost --}}
                            <div class="col-12 col-md-6 mb-3">
                                <label for="commission_value" class="form-label">{{ __('Costo') }}</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text">$</span>
                                    <input type="text" inputmode="decimal"
                                        class="form-control @error('commission_value') is-invalid @enderror"
                                        id="commission_value" name="commission_value"
                                        value="{{ old('commission_value', $parking->commission_value) }}"
                                        placeholder="0.00" required pattern="^\d*(\.\d{0,2})?$">

                                    @error('commission_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Row 3: Location Section Header --}}
                        <div class="mb-3">
                            <h5 class="h6 fw-bold text-gray-800">{{ __('Ubicación Geográfica') }}</h5>
                        </div>

                        {{-- Row 4: Coordinates Inputs --}}
                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="latitude" class="form-label small">{{ __('Latitud') }}</label>
                                <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                    id="latitude" name="latitude" value="{{ old('latitude', $parking->latitude) }}"
                                    placeholder="Ej. 19.432607">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="longitude" class="form-label small">{{ __('Longitud') }}</label>
                                <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                    id="longitude" name="longitude" value="{{ old('longitude', $parking->longitude) }}"
                                    placeholder="Ej. -99.133209">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Row 5: Geolocation Button & Map --}}
                        <div class="row">
                            <div class="col-12 mb-2">
                                <x-qpk-button type="primary" size="sm" id="btn-current-location">
                                    <x-qpk-icon name="locationDot" class="icon-xs me-2 text-white" />
                                    {{ __('Obtener ubicación actual') }}
                                </x-qpk-button>
                            </div>

                            <div class="col-12">
                                <div id="map" class="rounded border shadow-sm w-100"></div>
                                <div class="form-text text-muted mt-1">
                                    <small>{{ __('Haz clic en el mapa para fijar las coordenadas.') }}</small>
                                </div>
                            </div>
                        </div>

                    </x-qpk-card>
                </div>
            </div>

            {{-- SECTION 2: Schedules (Grid Layout) --}}
            <div class="row">
                <div class="col-12">
                    <x-qpk-card title="Horarios de Operación">
                        <p class="text-gray-500 small mb-4">
                            {{ __('Configura los días y horas en que el estacionamiento estará abierto.') }}
                        </p>

                        @error('schedules')
                            <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
                                <x-qpk-icon name="error" class="icon-xs me-2" />
                                <div>{{ $message }}</div>
                            </div>
                        @enderror

                        @php
                            $days = [
                                1 => 'Lunes',
                                2 => 'Martes',
                                3 => 'Miércoles',
                                4 => 'Jueves',
                                5 => 'Viernes',
                                6 => 'Sábado',
                                0 => 'Domingo',
                            ];
                        @endphp

                        <div class="row g-3">
                            @foreach ($days as $key => $day)
                                {{-- Get prepared data for this specific day --}}
                                @php
                                    $current = $schedules[$key];
                                @endphp

                                <div class="col-12 col-md-6 col-xl-4">
                                    {{-- Alpine Data: Simple logic using prepared data --}}
                                    {{-- Priority: 1. Old Input (Validation error), 2. DB Value (Prepared) --}}
                                    <div class="card h-100 border border-light shadow-sm p-3" x-data="{
                                        isOpen: {{ old('schedules.' . $key . '.is_open', $current['is_open'] ? 'true' : 'false') == '1' || old('schedules.' . $key . '.is_open', $current['is_open'] ? 'true' : 'false') === 'true' ? 'true' : 'false' }}
                                    }">
                                        <div
                                            class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                            <span class="fw-bold text-gray-800">{{ $day }}</span>
                                            <div class="form-check form-switch">
                                                <input type="hidden" name="schedules[{{ $key }}][weekday]"
                                                    value="{{ $key }}">

                                                <input type="hidden" name="schedules[{{ $key }}][is_open]"
                                                    :value="isOpen ? 1 : 0">

                                                <input class="form-check-input" type="checkbox"
                                                    id="switch_{{ $key }}" x-model="isOpen">
                                            </div>
                                        </div>

                                        <div x-show="isOpen" x-transition>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <label
                                                        class="form-label small text-muted mb-0">{{ __('Apertura') }}</label>
                                                    <input type="time"
                                                        class="form-control form-control-sm @error('schedules.' . $key . '.opening_time') is-invalid @enderror"
                                                        name="schedules[{{ $key }}][opening_time]"
                                                        value="{{ old('schedules.' . $key . '.opening_time', $current['opening_time']) }}">
                                                    @error('schedules.' . $key . '.opening_time')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6">
                                                    <label
                                                        class="form-label small text-muted mb-0">{{ __('Cierre') }}</label>
                                                    <input type="time"
                                                        class="form-control form-control-sm @error('schedules.' . $key . '.closing_time') is-invalid @enderror"
                                                        name="schedules[{{ $key }}][closing_time]"
                                                        value="{{ old('schedules.' . $key . '.closing_time', $current['closing_time']) }}">
                                                    @error('schedules.' . $key . '.closing_time')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div x-show="!isOpen" class="text-center py-2">
                                            <span class="badge bg-gray-200 text-gray-500 w-100">{{ __('Cerrado') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-qpk-card>
                </div>
            </div>

            {{-- Actions --}}
            <div class="row mt-3 mb-5">
                <div class="col-12 d-flex justify-content-start gap-2">
                    <x-qpk-button type="primary" submit="true">
                        <x-qpk-icon name="save" class="icon-xs me-2 text-white" />
                        {{ __('Guardar') }}
                    </x-qpk-button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    {{-- Mix Compiled Script --}}
    <script src="{{ asset('js/modules/parking/map-handler.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof window.initParkingMap === 'function') {
                window.initParkingMap();
            }
        });
    </script>
@endsection

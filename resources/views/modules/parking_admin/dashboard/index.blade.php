{{--
    Company: CETAM
    Project: QPK
    File: index.blade.php
    Created on: 02/12/2025
    Created by: Daniel Yair Mendoza Alvarez
    Approved by: Daniel Yair Mendoza Alvarez

    Changelog:
    - ID: 1 | Date: 02/12/2025
      Modified by: Daniel Yair Mendoza Alvarez
      Description: Dashboard view implementation featuring income cards and ApexCharts integration, adhering to Manual v4 UI standards. |
--}}

@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start py-2 mb-2">
        <div class="d-block mb-4 mb-md-0">
            <x-breadcrumb :items="[['label' => 'Inicio']]" />

            <h2 class="h4 mt-1">Inicio</h2>
            <p class="mb-0 text-gray-500">Resumen financiero y operativo de tu estacionamiento.</p>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center">
            <label for="chart-period-select" class="text-gray-500 mb-0 me-2 fw-normal">
                Filtrar por:
            </label>
            <div>
                <select id="chart-period-select" class="form-select w-auto pe-5">
                    <option value="day">Hoy</option>
                    <option value="week" selected>Semana</option>
                    <option value="month">Mes</option>
                </select>
            </div>
        </div>
    </div>

    {{-- 2. Statistics Cards Section --}}
    <div class="row mb-2">
        {{-- Card 1: Daily Income --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            {{-- Icon container with primary color (Manual Table 1) --}}
                            <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                <x-icon name="money.coins" size="lg" class="text-primary" />
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Ingresos Hoy</h2>
                                <h3 class="fw-extrabold mb-2 text-gray-900">
                                    ${{ number_format($stats['daily'], 2) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Weekly Income --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-secondary rounded me-4 me-sm-0">
                                <x-icon name="report.bar" size="lg" class="text-secondary" />
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Esta Semana</h2>
                                <h3 class="fw-extrabold mb-2 text-gray-900">
                                    ${{ number_format($stats['weekly'], 2) }}
                                </h3>
                            </div>
                            <div class="small d-flex mt-1">
                                <span class="text-gray-500">Lun - Dom</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Monthly Income --}}
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                <x-icon name="money.invoice" size="lg" class="text-info" />
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Este Mes</h2>
                                <h3 class="fw-extrabold mb-2 text-gray-900">
                                    ${{ number_format($stats['monthly'], 2) }}
                                </h3>
                            </div>
                            <div class="small d-flex mt-1">
                                <span class="text-gray-500">Acumulado mensual</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Main Chart Section --}}

    <div class="row">
        <div class="col-12 mb-4">
            <x-card>
                <h6 class="ms-4">Resumen de Ingresos</h6>
                <div id="parking-income-chart" class="w-100" data-url="{{ route('qpk.dashboard.chart') }}"
                    data-series='@json($chartData['series'])' data-categories='@json($chartData['categories'])'>
                </div>
            </x-card>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ mix('js/modules/dashboard/income-chart.js') }}"></script>
    <script src="{{ mix('js/modules/dashboard/dashboard-handler.js') }}"></script>
@endsection

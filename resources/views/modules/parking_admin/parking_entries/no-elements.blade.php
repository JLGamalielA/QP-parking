{{--
   Company: CETAM
   Project: QPK
   File: no-elements.blade.php
   Created on: 26/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Date: 26/11/2025
     Modified by: Daniel Yair Mendoza Alvarez
     Description: View to display when no parking entries (readers) exist
--}}

@extends('layouts.app')

@section('title', 'Lectores')

@section('content')
    <div class="py-2">
        <x-breadcrumb :items="[['label' => 'Lectores']]" />

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
            <div class="d-block mb-4 mb-md-0">
                <h2 class="h4">Lectores</h2>
                <p class="mb-0">Consulta los lectores de tu estacionamiento</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <x-button type="primary" :href="route('qpk.parking-entries.create')">
                    <x-icon name="action.create" class="me-2 text-white" />
                    Crear lector
                </x-button>
            </div>
        </div>

        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th class="border-bottom text-uppercase rounded-start">Nombre del lector</th>
                        <th class="border-bottom text-uppercase">Tipo</th>
                        <th class="border-bottom text-uppercase">Estado</th>
                        <th class="border-bottom text-uppercase rounded-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" class="text-center py-3 border-0">
                            <div class="mb-4">
                                <span class="text-gray-200">
                                    <x-icon name="action.scan" size="2x" />
                                </span>
                            </div>
                            <h2 class="h5 fw-bold text-gray-800 mb-3">
                                No hay lectores para mostrar
                            </h2>
                            <p class="text-gray-500 mb-4">
                                Configura los puntos de entrada y salida para tu estacionamiento
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="fw-normal small mt-4 mt-lg-0 ms-auto">
                Mostrando <b> 0</b> a <b> 0</b> de
                <b> 0</b> lectores
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/alert-handler.js') }}"></script>
    @if (session('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showSessionAlert(@json(session('swal')));
            });
        </script>
    @endif
@endsection

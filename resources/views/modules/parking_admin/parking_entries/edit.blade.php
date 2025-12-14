{{--
   Company: CETAM
   Project: QPK
   File: edit.blade.php
   Created on: 26/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 26/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Form to edit an existing Parking Entry (Reader). |
--}}

@extends('layouts.app')

@section('title', 'Editar Lector')

@section('content')
    <div class="py-2">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.dashboard.index') }}"><x-icon name="nav.home" size="xs" /></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('qpk.parking-entries.index') }}">Lectores</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
            <div class="d-block mb-4 mb-md-0">
                <h2 class="h4">Editar Lector</h2>
                <p class="mb-0"> Edita la información de tu lector. </p>
            </div>
        </div>

        <form action="{{ route('qpk.parking-entries.update', $entry->parking_entry_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-1">
                <div class="col-12">
                    <x-card>
                        <div class="row">
                            {{-- Name Field --}}
                            <div class="col-12 col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    Nombre del Lector <span class="text-danger">*</span>
                                </label>
                                <input type="text" maxlength="50"
                                    class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                    value="{{ old('name', $entry->name) }}" placeholder="Ej. Entrada Principal">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Type Field (Entry/Exit) --}}
                            <div class="col-12 col-md-6 mb-3">
                                <label for="is_entry" class="form-label">
                                    Tipo de Lector <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('is_entry') is-invalid @enderror" id="is_entry"
                                    name="is_entry">
                                    <option value="" disabled>Selecciona</option>

                                    @php
                                        $val = old('is_entry', $entry->is_entry);
                                        // Helper logic to handle boolean/integer casting from old input or DB
                                    @endphp

                                    <option value="1" {{ $val == 1 || $val === true ? 'selected' : '' }}>Entrada
                                    </option>
                                    <option value="0" {{ $val == 0 || $val === false ? 'selected' : '' }}>Salida
                                    </option>
                                </select>
                                @error('is_entry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start gap-2">
                                <x-button type="primary" :submit="true">
                                    <x-icon name="action.save" class="me-2" />
                                    Guardar
                                </x-button>
                                <x-button type="cancel" href="{{ route('qpk.parking-entries.index') }}">
                                    Cancelar
                                </x-button>
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/alert-handler.js') }}"></script>
@endsection

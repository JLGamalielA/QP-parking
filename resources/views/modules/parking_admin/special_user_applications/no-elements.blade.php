{{--
   Company: CETAM
   Project: QPK
   File: no-elements.blade.php
   Created on: 26/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez
   
   Changelog:
   - ID: 1 | Modified on: 26/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: no-elements view for Special User Applications. |
--}}

@extends('layouts.app')

@section('title', 'Solicitudes')

@section('content')
    <div class="py-4">
        <x-breadcrumb :items="[['label' => 'Solicitudes']]" />
        <div class="row justify-content-center">
            <div class="col-12">
                <x-card>
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <span class="text-gray-200">
                                {{-- Icon representing requests/inbox --}}
                                <x-icon name="msg.inbox" size="2x" />
                            </span>
                        </div>
                        <h2 class="h5 fw-bold text-gray-800 mb-3">
                            No tienes solicitudes pendientes.
                        </h2>
                        <p class="text-gray-500 mb-4">
                            Aquí aparecerán las solicitudes de usuarios que deseen un rol especial en tu estacionamiento.
                        </p>
                    </div>
                </x-card>
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

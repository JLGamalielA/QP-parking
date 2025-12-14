{{--
   Company: CETAM
   Project: QPK
   File: index.blade.php
   Created on: 07/12/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Date: 07/12/2025
     Modified by: Daniel Yair Mendoza Alvarez
     Description: Index view to consult the available parking plans
--}}

@extends('layouts.inactive')

@section('title', 'Suscripción')

@section('content')

    <div>
        <div class="py-2">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('qpk.parking-plans.index') }}"><x-icon name="nav.home" size="xs" /></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Suscripción</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-start mb-3">
                <div class="d-block mb-4 mb-md-0">
                    <h2 class="h4">Planes de Membresía</h2>
                    <p class="mb-0">Elige el plan que mejor se adapte a tus necesidades.</p>
                </div>
            </div>

            <div class="row justify-content-center">
                {{-- 
                  Display available subscriptions.
                  This loop handles the display of each subscription plan.
                --}}
                @foreach ($subscriptions as $subscription)
                    <div class="col-md-5 mb-4">
                        <div class="card h-100 shadow-lg border-primary border-2">
                            <div class="card-header text-center pt-4 pb-2 fw-bold bg-primary text-white">
                                <h4 class="card-title h5 mb-0">{{ $subscription->name }}</h4>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="text-center mb-4">
                                    <h2 class="my-3 text-primary fw-bolder">${{ number_format($subscription->price, 2) }}
                                        <small class="text-muted fs-6 fw-normal">/ mes</small>
                                    </h2>
                                    <p class="card-text text-gray-500 small px-3">
                                        {{ $subscription->name }} para estacionamiento</p>
                                </div>

                                <ul class="list-unstyled text-start mb-4 grow">
                                    @foreach ($subscription->benefits as $benefit)
                                        <li class="mb-2 d-flex align-items-center small">
                                            <x-icon name="state.success" class="me-2 text-success" />
                                            <span class="text-primary ms-1">{{ $benefit->benefit }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="mt-auto pt-3 border-top">
                                    <x-button type="primary" 
                                    :href="route('qpk.parking-plans.checkout', $subscription)" class="w-100 justify-content-center">
                                        <x-icon name="money.card" class="me-2 text-white" />
                                        Adquirir Plan
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

{{--
   Company: CETAM
   Project: QPK
   File: guest.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Guest layout for authentication pages. No sidebar included. |
--}}

@extends('layouts.base')

@section('content')
    <main>
        {{-- Full width/height container for Auth --}}
        {{ $slot }}
    </main>
@endsection


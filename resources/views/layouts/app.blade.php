{{--
   Company: CETAM
   Project: QPK
   File: app.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Refactored to extend 'layouts.base'. Forces Sidebar/Header inclusion without route logic. |
     Changelog:

   - ID: 3 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Fixed undefined $slot error by implementing hybrid content injection (@yield vs $slot). |
--}}

@extends('layouts.base')

@section('content')
    {{-- 1. Include Sidebar (Navigation) --}}
    @include('partials.sidenav')

    {{-- 2. Main Content Wrapper --}}
    <main class="content">

        {{-- 3. Include Topbar (Header) --}}
        @include('partials.topbar')

        {{-- 
           4. Page Content Injection Logic 
           CRITICAL FIX: Checks if a section named 'content' exists (from @extends).
           If not, it attempts to render the $slot (from Components).
           The '??' operator prevents the undefined variable error.
        --}}
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif

        {{-- 5. Include Footer --}}
        @include('partials.footer')

    </main>
@endsection

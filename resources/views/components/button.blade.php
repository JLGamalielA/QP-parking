{{--
   Company: CETAM
   Project: QPK
   File: qpk-button.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Date: 22/11/2025
     Modified by: Daniel Yair Mendoza Alvarez
     Description: Standard button component mapping generic types to Volt CSS classes
    
    - ID: 2 | Date: 23/11/2025
      Modified by: Daniel Yair Mendoza Alvarez
      Description: Update color mapping to use semantic Bootstrap classes aligned with SCSS variables
--}}

@props([
    'type' => 'primary',
    'size' => 'md',
    'submit' => false,
    'href' => null,
])

@php
    $classes = 'btn d-inline-flex align-items-center ';

    switch ($type) {
        case 'primary':
            $classes .= 'btn-primary ';
            break;
        case 'secondary':
            $classes .= 'btn-secondary text-white ';
            break;
        case 'danger':
            $classes .= 'btn-danger ';
            break;
        case 'info':
            $classes .= 'btn-info ';
            break;
        case 'warning':
            $classes .= 'btn-warning ';
            break;

        case 'cancel':
            $classes .= 'btn-gray-300 text-gray-800 hover:bg-gray-300 ';
            break;

        default:
            $classes .= 'btn-gray-800 ';
            break;
    }

    switch ($size) {
        case 'sm':
            $classes .= 'btn-sm ';
            break;
        case 'lg':
            $classes .= 'btn-lg ';
            break;
    }
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $submit ? 'submit' : 'button' }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

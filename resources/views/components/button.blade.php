{{--
   Company: CETAM
   Project: QPK
   File: qpk-button.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Standard button component mapping generic types to Volt CSS classes. |
    
    - ID: 2 | Modified on: 23/11/2025 |
      Modified by: Daniel Yair Mendoza Alvarez |
      Description: Update color mapping to use semantic Bootstrap classes (btn-primary, btn-secondary) aligned with SCSS variables. Added contrast utility classes. | 
--}}

@props([
    'type' => 'primary', // primary, secondary, danger, info, warning
    'size' => 'md', // sm, md, lg
    'submit' => false,
    'href' => null,
])

@php
    // Map abstract types to Volt/Bootstrap classes
    $classes = 'btn d-inline-flex align-items-center ';

    switch ($type) {
        case 'primary':
            $classes .= 'btn-primary ';
            break; // Volt primary is usually dark gray
        case 'secondary':
            $classes .= 'btn-secondary';
            break;
        case 'danger':
            $classes .= 'btn-danger ';
            break;
        case 'info':
            $classes .= 'btn-info';
            break;
        case 'warning':
            $classes .= 'btn-warning ';
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

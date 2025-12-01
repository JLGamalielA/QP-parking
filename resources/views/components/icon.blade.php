{{--
    Company: CETAM
    Project: QPK
    File: icon.blade.php
    Created on: 01/12/2025
    Created by: Daniel Yair Mendoza Alvarez
    Approved by: Daniel Yair Mendoza Alvarez

    Changelog:
    - ID: 1 | Modified on: 01/12/2025 |
      Modified by: Daniel Yair Mendoza Alvarez |
      Description: Component updated to map sizes to Font Awesome standard classes (fa-*) as required. |
--}}

@props([
    'name' => 'question', // Default alias key
    'size' => null, // Sizes: xs, sm, lg, 2x, 3x (Matches Manual v3 Table 17)
    'color' => '', // Utility classes: text-primary, text-danger
    'class' => '', // Custom classes injected from view
    'spin' => false, // Animation toggle
])

@php
    $iconsConfig = config('icons');

    $iconClass = $iconsConfig[$name] ?? null;

    if (!$iconClass) {
        $iconClass = $iconsConfig['support.help'] ?? 'fa-solid fa-circle-question';
    }

    $sizeClass = '';
    if ($size) {
        $sizeClass = match ($size) {
            'xs', 'xxs' => 'fa-xs',
            'sm', 'small' => 'fa-sm',
            'lg', 'large' => 'fa-lg',
            'xl', '2x' => 'fa-2x',
            'xxl', '3x' => 'fa-3x',
            default => '',
        };
    }

    $classes = "{$iconClass} {$sizeClass} {$color} {$class}";

    if ($spin) {
        $classes .= ' fa-spin';
    }
@endphp

<i {{ $attributes->merge(['class' => $classes, 'aria-hidden' => 'true']) }}></i>

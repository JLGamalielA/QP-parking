{{--
   Company: CETAM
   Project: QPK
   File: icon.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025
     Modified by: Daniel Yair Mendoza Alvarez
     Description: Reusable Blade component for standardized icon rendering.
--}}

@props([
    'name' => 'question', // Icon alias (see config/icons.php)
    'size' => 'md', // Size: xs, sm, md, lg, xl, 2x, 3x
    'color' => '', // CSS color or color class
    'class' => '', // Additional classes
    'spin' => false, // Rotation animation
    'pulse' => false, // Pulse animation
    'fixedWidth' => false, // Fixed width for alignment
    'ariaLabel' => '', // Accessibility label
    'ariaHidden' => true, // Hide from screen readers by default
])

@php
    // Get the Font Awesome class from the configuration file
    $iconClass = config("icons.icons.{$name}");

    // If alias does not exist, use default question icon
    if (!$iconClass) {
        $iconClass = config('icons.icons.question', 'fa-solid fa-question');
    }

    // Build base classes
    $classes = [$iconClass];

    // Add size
    if ($size !== 'md') {
        $sizeClass = config("icons.sizes.{$size}");
        if ($sizeClass) {
            $classes[] = $sizeClass;
        }
    }

    // Add animations
    if ($spin) {
        $classes[] = 'fa-spin';
    }

    if ($pulse) {
        $classes[] = 'fa-pulse';
    }

    // Add fixed width
    if ($fixedWidth) {
        $classes[] = 'fa-fw';
    }

    // Add custom classes
    if ($class) {
        $classes[] = $class;
    }

    // Build accessibility attributes
    $ariaAttributes = [];

    if ($ariaHidden) {
        $ariaAttributes['aria-hidden'] = 'true';
    }

    if ($ariaLabel) {
        $ariaAttributes['aria-label'] = $ariaLabel;
        $ariaAttributes['role'] = 'img';
    }

    // Build color style if provided
    $styleString = '';
    if ($color) {
        // If color is a CSS class (starts with text-), add to classes
        if (substr($color, 0, 5) === 'text-') {
            $classes[] = $color;
        } else {
            // If hex or RGB, add as inline style
            $styleString = "color: {$color};";
        }
    }

    // Convert array to string (after adding all classes)
    $classString = implode(' ', $classes);
@endphp

<i
    {{ $attributes->merge(
        [
            'class' => $classString,
            'style' => $styleString ?: null,
        ] + $ariaAttributes,
    ) }}></i>

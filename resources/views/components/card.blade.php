{{--
   Company: CETAM
   Project: QPK
   File: qpk-card.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Reusable Card component based on Volt template styles (Bootstrap 5). |
--}}

@props(['title' => null])

<div {{ $attributes->merge(['class' => 'card border-0 shadow mb-4']) }}>
    <div class="card-body">
        @if ($title || isset($actions))
            <div class="d-flex justify-content-between align-items-center mb-3">
                @if ($title)
                    <h2 class="h5 mb-0">{{ $title }}</h2>
                @elseif (isset($titleSlot))
                    <h2 class="h5 mb-0">{{ $titleSlot }}</h2>
                @endif

                @if (isset($actions))
                    <div>
                        {{ $actions }}
                    </div>
                @endif
            </div>
        @endif

        {{ $slot }}
    </div>
</div>

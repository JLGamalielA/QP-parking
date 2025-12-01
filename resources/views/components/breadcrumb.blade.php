{{--
    Company: CETAM
    Project: QPK
    File: breadcrumb.blade.php
    Created on: 30/11/2025
    Created by: Daniel Yair Mendoza Alvarez
    Approved by: Daniel Yair Mendoza Alvarez

    Changelog:
    - ID: 1 | Date: 30/11/2025
      Modified by: Daniel Yair Mendoza Alvarez
      Description: Creation of reusable dynamic breadcrumb component adhering to Volt template styles. |

    - ID: 2 | Date: 30/11/2025
      Modified by: Daniel Yair Mendoza Alvarez
      Description: Removed icon support for dynamic items to strictly limit icons to the dashboard home link. |
--}}

@props(['items' => []])

<div class="d-block mb-4 mb-md-0">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">

            {{-- 1. Static Element: Always visible with icon (Dashboard link) --}}
            <li class="breadcrumb-item">
                <a href="{{ route('qpk.dashboard.index') }}">
                    <x-icon name="nav.home" class="icon-xxs" />
                </a>
            </li>

            {{-- 2. Dynamic Elements (Text Only) --}}
            @foreach ($items as $item)
                @php
                    // Determine if the current item is the active page (last in the list)
                    $isActive = $loop->last;
                    $label = $item['label'] ?? '';
                    $route = $item['route'] ?? null;

                    // Handle optional route parameters if provided
                    $params = $item['params'] ?? [];
                @endphp

                <li class="breadcrumb-item {{ $isActive ? 'active' : '' }}"
                    @if ($isActive) aria-current="page" @endif>

                    @if (!$isActive && $route)
                        {{-- Case: Intermediate item with a valid route --}}
                        <a href="{{ route($route, $params) }}">
                            {{ $label }}
                        </a>
                    @else
                        {{-- Case: Active item (current page) or item without a route --}}
                        {{ $label }}
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>

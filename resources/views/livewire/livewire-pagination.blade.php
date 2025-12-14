{{--
    Company: CETAM
    Project: QPK
    File: livewire-pagination.blade.php
    Created on: 30/11/2025
    Created by: Daniel Yair Mendoza Alvarez
    Approved by: Daniel Yair Mendoza Alvarez

    Changelog:
    - ID: 1 | Modified on: 30/11/2025
      Modified by: Daniel Yair Mendoza Alvarez
      Description: Custom Livewire pagination view located in livewire directory. |
--}}

@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">Anterior</span>
                </li>
            @else
                <li class="page-item">
                    <button type="button" class="page-link" wire:click="previousPage" wire:loading.attr="disabled"
                        rel="prev">
                        Anterior
                    </button>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span
                            class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span
                                    class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item">
                                <button type="button" class="page-link" wire:click="gotoPage({{ $page }})">
                                    {{ $page }}
                                </button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <button type="button" class="page-link" wire:click="nextPage" wire:loading.attr="disabled"
                        rel="next">
                        Siguiente
                    </button>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">Siguiente</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

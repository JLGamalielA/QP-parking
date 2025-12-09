{{--
    Company: CETAM
    Project: QPK
    File: modal.blade.php
    Created on: 09/12/2025
    Created by: Daniel Yair Mendoza Alvarez
    Approved by: Daniel Yair Mendoza Alvarez

    Changelog:
    - ID: 1 | Modified on: 09/12/2025 |
      Modified by: Daniel Yair Mendoza Alvarez |
      Description: Modal used to show terms and conditions or other important information. |
--}}

@props(['id', 'title'])

<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h6 modal-title" id="{{ $id }}Label">{{ $title }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-justify">
                {{ $slot }}
            </div>

        </div>
    </div>
</div>

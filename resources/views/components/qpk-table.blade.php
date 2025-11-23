{{--
   Company: CETAM
   Project: QPK
   File: qpk-table.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Reusable Table component with Volt responsive classes. |
--}}

<div class="table-responsive">
    <table class="table table-centered table-nowrap mb-0 rounded">
        <thead class="thead-light">
            {{ $head }}
        </thead>
        <tbody>
            {{ $body }}
        </tbody>
    </table>
</div>

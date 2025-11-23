 {{--
   Company: CETAM
   Project: QPK
   File: dashboard.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Dashboard view refactored to extend 'layouts.app' and use standardized <x-icon> components. |
        Changelog:

   - ID: 2 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Fixed Livewire MultipleRootElementsDetectedException by wrapping content in a single root div. |

   - ID: 3 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Removed @extends and @section to fix Livewire layout conflict. Sidebar is now handled by the component class. |
--}}

 @extends('layouts.app')

 @section('title', 'Inicio')

 @section('content')
     <div class="py-4">

     </div>
 @endsection

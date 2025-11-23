 {{--
   Company: CETAM
   Project: QPK
   File: sidenav.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Refactored sidebar with standardized <x-qpk-icon> components and dynamic active states. |

   - ID: 3 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Migration of QParking specific menu items (Parking, Users, Readers, Requests) using standard icons. |
--}}

 <nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
     <div class="sidebar-inner px-2 pt-3">

         {{-- Mobile User Card --}}
         <div
             class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
             <div class="d-flex align-items-center">
                 <div class="avatar-lg me-4">
                     <img src="{{ asset('assets/img/team/profile-picture-3.jpg') }}"
                         class="card-img-top rounded-circle border-white" alt="User Image">
                 </div>
                 <div class="d-block">
                     <h2 class="h5 mb-3">Hi, User</h2>
                     <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.login') }}"
                         class="btn btn-secondary btn-sm d-inline-flex align-items-center">
                         <x-qpk-icon name="signOut" class="icon-xxs me-1" />
                         Sign Out
                     </a>
                 </div>
             </div>
             <div class="collapse-close d-md-none">
                 <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
                     aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                     <x-qpk-icon name="close" class="icon-xs" />
                 </a>
             </div>
         </div>

         {{-- Main Navigation --}}
         <ul class="nav flex-column pt-3 pt-md-0">

             {{-- Brand --}}
             <li class="nav-item">
                 <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}"
                     class="nav-link d-flex align-items-center">
                     <span class="sidebar-icon me-3">
                         <img src="{{ asset('assets/img/brand/light.svg') }}" height="20" width="20"
                             alt="QParking Logo">
                     </span>
                     <span class="mt-1 ms-1 sidebar-text">QParking</span>
                 </a>
             </li>

             {{-- 1. Panel (Dashboard) --}}
             <li
                 class="nav-item {{ request()->routeIs(config('proj.route_name_prefix', 'proj') . '.dashboard*') ? 'active' : '' }}">
                 <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}" class="nav-link">
                     <span class="sidebar-icon">
                         <x-qpk-icon name="home" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">{{ __('Inicio') }}</span>
                 </a>
             </li>

             {{-- 2. Estacionamiento --}}
             {{-- Icon: mapLocationDot (Location/Map category) --}}
             <li class="nav-item">
                 <a href="#" class="nav-link">
                     <span class="sidebar-icon">
                         <x-qpk-icon name="mapLocationDot" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">{{ __('Estacionamiento') }}</span>
                 </a>
             </li>

             {{-- 3. Tipos de usuarios --}}
             {{-- Icon: usersGear (Users & Roles category) --}}
             <li class="nav-item">
                 <a href="#" class="nav-link">
                     <span class="sidebar-icon">
                         <x-qpk-icon name="usersGear" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">{{ __('Tipos de usuarios') }}</span>
                 </a>
             </li>

             {{-- 4. Lectores --}}
             {{-- Icon: idCard (Access & Security category) or wifi/rss --}}
             <li class="nav-item">
                 <a href="#" class="nav-link">
                     <span class="sidebar-icon">
                         <x-qpk-icon name="idCard" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">{{ __('Lectores') }}</span>
                 </a>
             </li>

             {{-- 5. Entradas activas --}}
             {{-- Icon: flag (Status category) or car/parking if available, using flag for 'active' --}}
             <li class="nav-item">
                 <a href="#" class="nav-link">
                     <span class="sidebar-icon">
                         <x-qpk-icon name="flag" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">{{ __('Entradas activas') }}</span>
                 </a>
             </li>

             {{-- 6. Usuarios especiales --}}
             {{-- Icon: userStar/userTie (Users category) --}}
             <li class="nav-item">
                 <a href="#" class="nav-link">
                     <span class="sidebar-icon">
                         <x-qpk-icon name="userTie" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">{{ __('Usuarios especiales') }}</span>
                 </a>
             </li>

             {{-- 7. Solicitudes --}}
             {{-- Icon: envelopeOpen/inbox (Communication category) --}}
             <li class="nav-item">
                 <a href="#" class="nav-link">
                     <span class="sidebar-icon">
                         <x-qpk-icon name="envelopeOpen" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">{{ __('Solicitudes') }}</span>
                 </a>
             </li>
         </ul>
     </div>
 </nav>

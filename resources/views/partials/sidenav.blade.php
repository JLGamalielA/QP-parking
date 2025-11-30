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
     Description: Refactored sidebar with standardized <x-icon> components and dynamic active states. |

   - ID: 3 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Migration of QParking specific menu items (Parking, Users, Readers, Requests) using standard icons. |

    - ID: 4 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Sidebar menu updated to match the legacy QParking structure with standard icons and routes. |
--}}

 <nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
     <div class="sidebar-inner px-2 pt-3">

         <div
             class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
             <div class="d-flex align-items-center">
                 <div class="avatar-lg me-4">
                     <img src="{{ asset('assets/img/team/profile-picture-3.jpg') }}"
                         class="card-img-top rounded-circle border-white" alt="User Image">
                 </div>
                 <div class="d-block">
                     <h2 class="h5 mb-3">Hola, Usuario</h2>
                     <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.auth.login') }}"
                         class="btn btn-secondary btn-sm d-inline-flex align-items-center">
                         <x-icon name="auth.logout" class="icon-xxs me-1" />
                         Cerrar sesión
                     </a>
                 </div>
             </div>

             {{-- 
                Mobile Close Button (The 'X')
                This toggles the #sidebarMenu div back to hidden state.
            --}}
             <div class="collapse-close d-md-none">
                 <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
                     aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                     <x-icon name="nav.close" class="icon-xs" />
                 </a>
             </div>
         </div>

         {{-- Main Navigation Menu --}}
         <ul class="nav flex-column pt-3 pt-md-0">

             {{-- Brand / Logo --}}
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

             {{-- Dashboard --}}
             <li
                 class="nav-item {{ request()->routeIs(config('proj.route_name_prefix', 'proj') . '.dashboard*') ? 'active' : '' }}">
                 <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}" class="nav-link">
                     <span class="sidebar-icon">
                         <x-icon name="nav.home" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">Panel</span>
                 </a>
             </li>

             {{-- Parking Management --}}
             <li class="nav-item {{ request()->routeIs('*.parkings.*') ? 'active' : '' }}">
                 <a href="{{ route('qpk.parkings.index') }}" class="nav-link">
                     <span class="sidebar-icon">
                         <x-icon name="geo.location" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">Estacionamiento</span>
                 </a>
             </li>

             {{-- User Roles/Types --}}
             <li class="nav-item {{ request()->routeIs('*.special-parking-roles.*') ? 'active' : '' }}">
                 <a href="{{ route('qpk.special-parking-roles.index') }}" class="nav-link">
                     <span class="sidebar-icon">
                         <x-icon name="user.gear" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">Tipos de usuarios</span>
                 </a>
             </li>

             {{-- Scanners/Readers --}}
             <li class="nav-item {{ request()->routeIs('*.parking-entries.*') ? 'active' : '' }}">
                 <a href="{{ route('qpk.parking-entries.index') }}" class="nav-link">
                     <span class="sidebar-icon">
                         <x-icon name="action.scan" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">Lectores</span>
                 </a>
             </li>

             {{-- Active Entries --}}
             <li class="nav-item {{ request()->routeIs('*.active-user-qr-scans.*') ? 'active' : '' }}">
                 <a href="{{ route('qpk.active-user-qr-scans.index') }}" class="nav-link">
                     <span class="sidebar-icon">
                         <x-icon name="action.flag" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text"> Entradas activas </span>
                 </a>
             </li>

             {{-- Special Users --}}
             <li class="nav-item {{ request()->routeIs('*.special-parking-users.*') ? 'active' : '' }}">
                 <a href="{{ route('qpk.special-parking-users.index') }}" class="nav-link">
                     <span class="sidebar-icon">
                         <x-icon name="user.list" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">Usuarios especiales</span>
                 </a>
             </li>

             {{-- Applications --}}
             <li class="nav-item {{ request()->routeIs('*.special-user-applications.*') ? 'active' : '' }}">
                 <a href="{{ route('qpk.special-user-applications.index') }}" class="nav-link">
                     <span class="sidebar-icon">
                         <x-icon name="msg.inbox" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">Solicitudes</span>
                 </a>
             </li>

         </ul>
     </div>
 </nav>

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
--}}

 <nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
     <div class="sidebar-inner px-2 pt-3">

         {{-- Mobile User Card (Visible only on xs/sm/md) --}}
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
                         <x-icon name="signOut" class="icon-xxs me-1" />
                         Sign Out
                     </a>
                 </div>
             </div>
             <div class="collapse-close d-md-none">
                 <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
                     aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                     <x-icon name="close" class="icon-xs" />
                 </a>
             </div>
         </div>

         {{-- Navigation Links --}}
         <ul class="nav flex-column pt-3 pt-md-0">

             {{-- Brand / Logo --}}
             <li class="nav-item">
                 <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}"
                     class="nav-link d-flex align-items-center">
                     <span class="sidebar-icon me-3">
                         <img src="{{ asset('assets/img/brand/light.svg') }}" height="20" width="20"
                             alt="Volt Logo">
                     </span>
                     <span class="mt-1 ms-1 sidebar-text">
                         QParking
                     </span>
                 </a>
             </li>

             {{-- Dashboard Link (Active State Logic Included) --}}
             <li
                 class="nav-item {{ request()->routeIs(config('proj.route_name_prefix', 'proj') . '.dashboard*') ? 'active' : '' }}">
                 <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}" class="nav-link">
                     <span class="sidebar-icon">
                         <x-icon name="dashboard" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">Dashboard</span>
                 </a>
             </li>

             {{-- Laravel Examples Dropdown --}}
             <li class="nav-item">
                 <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                     data-bs-toggle="collapse" data-bs-target="#submenu-laravel">
                     <span>
                         <span class="sidebar-icon">
                             {{-- Using fileCode as a generic dev icon since 'fab' is not in standard config --}}
                             <x-icon name="fileCode" class="me-2" style="color: #fb503b;" />
                         </span>
                         <span class="sidebar-text" style="color: #fb503b;">Laravel Examples</span>
                     </span>
                     <span class="link-arrow">
                         <x-icon name="chevronRight" class="icon-sm" />
                     </span>
                 </span>
                 <div class="multi-level collapse" role="list" id="submenu-laravel" aria-expanded="false">
                     <ul class="flex-column nav">
                         <li class="nav-item {{ request()->routeIs('*.profile.*') ? 'active' : '' }}">
                             <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.profile.index') }}"
                                 class="nav-link">
                                 <span class="sidebar-text">Profile</span>
                             </a>
                         </li>
                         <li class="nav-item {{ request()->routeIs('*.users.*') ? 'active' : '' }}">
                             <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.users.index') }}"
                                 class="nav-link">
                                 <span class="sidebar-text">User Management</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>

             <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>

             {{-- Documentation Link --}}
             <li class="nav-item">
                 <a href="#" class="nav-link d-flex align-items-center">
                     <span class="sidebar-icon">
                         <x-icon name="file" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">Documentation</span>
                 </a>
             </li>

             {{-- Example: Static Links --}}
             <li class="nav-item">
                 <a href="#" class="nav-link d-flex align-items-center">
                     <span class="sidebar-icon">
                         <x-icon name="map" class="icon-xs me-2" />
                     </span>
                     <span class="sidebar-text">Map</span>
                 </a>
             </li>
         </ul>
     </div>
 </nav>

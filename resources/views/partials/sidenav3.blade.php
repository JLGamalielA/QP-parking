  {{--
   Company: CETAM
   Project: QPK
   File: sidenav3.blade.php
   Created on: 08/12/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 08/12/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Subscriptions sidenav showed when user subscription is over. |
--}}

  <nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
      <div class="sidebar-inner px-2 pt-3">

          <div
              class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">

              <div class="collapse-close d-md-none">
                  <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
                      aria-expanded="true" aria-label="Toggle navigation">
                      <x-icon name="nav.close" class="icon-xs" />
                  </a>
              </div>
          </div>

          {{-- Main Navigation Menu --}}
          <ul class="nav flex-column pt-3 pt-md-0">

              {{-- Brand / Logo --}}
              <li class="nav-item">
                  <a href="{{ route('qpk.parking-plans.index') }}" class="nav-link d-flex align-items-center">
                      <span class="sidebar-icon me-3">
                          <img src="{{ asset('assets/img/brand/logoQP.png') }}" height="30" width="30"
                              alt="QParking Logo" class="object-fit-contain">
                      </span>
                      <span class="mt-1 ms-1 sidebar-text">QParking</span>
                  </a>
              </li>
              {{-- Subscriptions --}}
              <li class="nav-item {{ request()->routeIs('*.parking-plans.*') ? 'active' : '' }}">
                  <a href="{{ route('qpk.parking-plans.index') }}" class="nav-link">
                      <span class="sidebar-icon">
                          <x-icon name="msg.inbox" size="xs" class="me-2" />
                      </span>
                      <span class="sidebar-text">Suscripción</span>
                  </a>
              </li>
          </ul>
      </div>
  </nav>

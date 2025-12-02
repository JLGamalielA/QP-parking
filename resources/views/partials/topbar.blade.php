{{--
    Company: CETAM
    Project: QPK
    File: topbar.blade.php
    Created on: 01/12/2025
    Created by: Daniel Yair Mendoza Alvarez
    Approved by: Daniel Yair Mendoza Alvarez

    Changelog:
    - ID: 1 | Modified on: 01/12/2025 |
      Modified by: Daniel Yair Mendoza Alvarez |
      Description: Updated user avatar to display dynamic initials instead of static image, adhering to Manual v3 design standards. |
--}}


<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-end w-100" id="navbarSupportedContent">

            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown ms-lg-3">
                    <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="media d-flex align-items-center">

                            {{-- User Initials Avatar --}}
                            <div class="avatar-initials me-2">
                                {{ auth()->user()->initials ?? 'US' }}
                            </div>
                            <div class="media-body  text-dark align-items-center d-none d-lg-block">
                                <span class="mb-0 font-small fw-bold text-gray-900">
                                    {{ auth()->user()->first_name ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'User Name' }}
                                </span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                        {{-- Profile Link --}}
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            {{-- <x-icon name="user.profile" class="dropdown-icon text-gray-400 me-2" /> --}}
                            <x-icon name="user.profile" class="dropdown-icon text-primary me-2" />
                            Mi perfil
                        </a>
                        <div role="separator" class="dropdown-divider my-1"></div>
                        {{-- Logout --}}
                        <a class="dropdown-item d-flex align-items-center">
                            <livewire:logout />
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

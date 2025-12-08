{{--
    Company: CETAM
    Project: QPK
    File: nav2.blade.php
    Created on: 08/12/2025
    Created by: Daniel Yair Mendoza Alvarez
    Approved by: Daniel Yair Mendoza Alvarez

    Changelog:
    - ID: 1 | Modified on: 08/12/2025
      Modified by: Daniel Yair Mendoza Alvarez
      Description: nav view for general admins only. |
--}}

<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
    <a class="navbar-brand me-lg-5" href="{{ route('qpk.admin-dashboard.index') }}">
        <img class="navbar-brand-dark" src="{{ asset('assets/img/brand/logoQP.png') }}" alt="QParking Logo" />
        <img class="navbar-brand-light" src="{{ asset('assets/img/brand/logoQP.png') }}" alt="QParking Logo" />
    </a>
    <div class="d-flex align-items-center">
        <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

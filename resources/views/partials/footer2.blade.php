{{--
   Company: CETAM
   Project: QPK
   File: footer2.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Standardized footer2 component. |
--}}

<footer>
    <div class="container">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class=" text-lg-center">
                <!-- List -->
                <ul class="list-inline list-group-flush list-group-borderless">
                    <li class="list-inline-item px-0 px-sm-2">
                        <a class='text-info' href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Términos de
                            uso</a>
                    </li>
                    <li class="list-inline-item px-0 px-sm-2">
                        <a class='text-info' href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Aviso
                            de privacidad</a>
                    </li>
                </ul>
                <p class="mb-0 text-center">
                    © 2025
                    <span>
                        QParking - Gestión de Estacionamientos
                    </span>
                </p>
            </div>
        </div>
    </div>
    <x-modal id="termsModal" title="Términos de Uso">
        @include('partials.terms-content')
    </x-modal>

    <x-modal id="privacyModal" title="Aviso de Privacidad">
        @include('partials.privacy-content')
    </x-modal>
</footer>

{{--
   Company: CETAM
   Project: QPK
   File: footer.blade.php
   Created on: 22/11/2025
   Created by: Daniel Yair Mendoza Alvarez
   Approved by: Daniel Yair Mendoza Alvarez

   Changelog:
   - ID: 1 | Modified on: 22/11/2025 |
     Modified by: Daniel Yair Mendoza Alvarez |
     Description: Standardized footer component removing the floating settings button. |
--}}

<footer class="bg-white rounded shadow p-5 mb-4 mt-4">
    <div class="row align-items-center">
        <div class="col-12 col-md-6 text-center text-md-start mb-3 mb-md-0">
            <p class="mb-0">
                © 2025 QParking - Gestor de estacionamientos
            </p>
        </div>
        <div class="col-12 col-md-6 text-center text-md-end">
            <a class="text-info text-decoration-none me-3" href="#" data-bs-toggle="modal"
                data-bs-target="#termsModal">
                Términos de uso
            </a>
            <a class="text-info text-decoration-none" href="#" data-bs-toggle="modal"
                data-bs-target="#privacyModal">
                Aviso de privacidad
            </a>
        </div>
    </div>
    <x-modal id="termsModal" title="Términos de Uso">
        @include('partials.terms-content')
    </x-modal>

    <x-modal id="privacyModal" title="Aviso de Privacidad">
        @include('partials.privacy-content')
    </x-modal>
</footer>

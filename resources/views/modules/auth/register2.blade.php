<section class="min-vh-100 bg-soft d-flex align-items-center py-5">
    <div class="container">
        <div wire:ignore.self class="row justify-content-center">
            <div class="col-12 d-flex align-items-center justify-content-center flex-colum">

                <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500 mb-4">
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <h1 class="mb-2 h3">Crear Cuenta</h1>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <x-icon name="success" class="me-2" /> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form wire:submit.prevent="register" class="mt-4">
                        @if ($currentStep === 1)

                            <h4 class="mb-4 text-center text-primary">Datos de acceso</h4>
                            <div class="form-group mb-4">
                                <label for="name">Nombre del Negocio <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Nombre del negocio" id="name" autofocus>
                                </div>
                                @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="email">Correo Electrónico <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model.blur="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="ejemplo@institucion.com" id="email">
                                </div>
                                @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="password">Contraseña <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password">
                                </div>
                                @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="passwordConfirmation">Confirmar Contraseña <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model="passwordConfirmation" type="password"
                                        class="form-control @error('passwordConfirmation') is-invalid @enderror"
                                        id="passwordConfirmation">
                                </div>
                                @error('passwordConfirmation') <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        @if ($currentStep === 2)
                            <h4 class="mb-4 text-center text-primary">Datos de domicilio</h4>
                            
                            <div class="form-group mb-4">
                                <label for="zipCode">Código Postal <span class="text-danger">*</span></label>
                                <input wire:model.live="zipCode" type="text"
                                    class="form-control @error('zipCode') is-invalid @enderror" placeholder="5 dígitos"
                                    id="zipCode" maxlength="5" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('zipCode') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="colony">Colonia <span class="text-danger">*</span></label>
                                <select wire:model="colony" class="form-select @error('colony') is-invalid @enderror"
                                    id="colony" @disabled(empty($colonyOptions))>
                                    <option value="" disabled @selected(empty($colonyOptions))>
                                        @if (empty($colonyOptions)) Ingresa un Código Postal @else Selecciona tu colonia
                                        @endif
                                    </option>
                                    @foreach ($colonyOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('colony') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="city">Estado <span class="text-danger">*</span></label>
                                <input wire:model="city" type="text" class="form-control bg-light" id="city" readonly>
                            </div>

                            <div class="form-group mb-4">
                                <label for="municipality">Municipio / Alcaldía <span class="text-danger">*</span></label>
                                <input wire:model="municipality" type="text" class="form-control bg-light" id="municipality"
                                    readonly>
                            </div>

                            <div class="form-group mb-4">
                                <label for="street">Calle <span class="text-danger">*</span></label>
                                <input wire:model.blur="street" type="text"
                                    class="form-control @error('street') is-invalid @enderror"
                                    placeholder="Ej: Av. Principal del Sol" id="street"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z0-9ñ .]/g, '')">
                                @error('street') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-4">
                                        <label for="extNumber">Número Exterior <span class="text-danger">*</span></label>
                                        <input wire:model.blur="extNumber" type="text"
                                            class="form-control @error('extNumber') is-invalid @enderror" placeholder=""
                                            id="extNumber" oninput="this.value = this.value.replace(/[^a-zA-Z0-9ñ]/g, '')">
                                        @error('extNumber') <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="contactNumber">Teléfono <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model="contactNumber" type="tel"
                                        class="form-control @error('contactNumber') is-invalid @enderror"
                                        placeholder="10 dígitos" id="contactNumber" maxlength="10"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                                @error('contactNumber') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="card border-light shadow-sm mt-3">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div>
                                            <h5 class="text-primary mb-1">Ubicación Exacta</h5>
                                            <p class="text-muted small mb-0">
                                                Confirma la ubicación en el mapa para que tus clientes lleguen sin
                                                problemas.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#mapModal" @disabled(empty($zipCode) || empty($colony) || empty($street) || empty($extNumber))>
                                            Abrir Mapa
                                        </button>
                                    </div>

                                    @if(empty($zipCode) || empty($colony) || empty($street) || empty($extNumber))
                                        <p class="text-center text-danger small mt-2 mb-0">
                                            Completa la dirección para ver el mapa.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($currentStep === 3)
                            <h4 class="mb-4 text-center text-primary">Datos fiscales</h4>
                            @php
                                $isFormal = $businessType === 'formal';
                                $isInformal = !$isFormal;
                            @endphp

                            <div class="form-group mb-4">
                                <label for="businessType">Clasificación del Negocio <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select wire:model.live="businessType"
                                        class="form-select @error('businessType') is-invalid @enderror" id="businessType">
                                        <option value="informal">Informal (Sin RFC)</option>
                                        <option value="formal">Formal (Persona Moral/Física con RFC)</option>
                                    </select>
                                </div>
                                @error('businessType') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="rfc">RFC <span class="text-danger">@if (!$isInformal)*@endif</span></label>
                                <div class="input-group">
                                    <input wire:model="rfc" type="text"
                                        class="form-control text-uppercase @error('rfc') is-invalid @enderror"
                                        placeholder="XAXX010101000" maxlength="13" @disabled($isInformal)>
                                </div>
                                @error('rfc') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="fiscalRegime">Régimen Fiscal <span
                                        class="text-danger">@if (!$isInformal)*@endif</span></label>
                                <select wire:model="fiscalRegime"
                                    class="form-select @error('fiscalRegime') is-invalid @enderror" @disabled($isInformal)>
                                    <option value="">Selecciona una opción</option>
                                    @foreach($fiscalRegimes as $code => $name)
                                        <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('fiscalRegime') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="legalName">Razón Social <span
                                        class="text-danger">@if (!$isInformal)*@endif</span></label>
                                <div class="input-group">
                                    <input wire:model="legalName" type="text"
                                        class="form-control @error('legalName') is-invalid @enderror"
                                        placeholder="Empresa S.A. de C.V." @disabled($isInformal)
                                        oninput="this.value = this.value.replace(/[^a-zA-Z0-9ñ .´]/g, '')">
                                </div>
                                @error('legalName') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="billingEmail">Correo de Facturación <span
                                        class="text-danger">@if (!$isInformal)*@endif</span></label>
                                <div class="input-group">
                                    <input wire:model="billingEmail" type="email"
                                        class="form-control @error('billingEmail') is-invalid @enderror"
                                        placeholder="ejemplo@institucion.com" @disabled($isInformal)>
                                </div>
                                @error('billingEmail') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-check mb-4">
                                <input wire:model.live="sameFiscalAddress" class="form-check-input" type="checkbox"
                                    id="sameAddress" @disabled($isInformal)>
                                <label class="form-check-label" for="sameAddress">
                                    Mi dirección fiscal es la misma que la ubicación del negocio
                                </label>
                            </div>

                            @if (!$sameFiscalAddress && !$isInformal)
                                <div class="form-group mb-4">
                                    <label for="fiscalZipCode">Código Postal <span class="text-danger">*</span></label>
                                    <input wire:model="fiscalZipCode" type="text"
                                        class="form-control @error('fiscalZipCode') is-invalid @enderror" placeholder=""
                                        maxlength="5" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    @error('fiscalZipCode') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="fiscalAddress">Dirección Fiscal Completa <span
                                            class="text-danger">*</span></label>
                                    <input wire:model="fiscalAddress" type="text"
                                        class="form-control @error('fiscalAddress') is-invalid @enderror"
                                        placeholder="Calle, Número, Colonia, Municipio, Estado"
                                        oninput="this.value = this.value.replace(/[^a-zA-Z0-9ñ .]/g, '')">
                                    @error('fiscalAddress') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            @endif
                        @endif

                        @if ($currentStep === 4)
                            <h4 class="mb-4 text-center text-primary">Finalizar Registro</h4>

                            <div class="row justify-content-center">
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <div class="d-flex justify-content-center">
                                            <div class="form-check">
                                                <input wire:model="terms"
                                                    class="form-check-input @error('terms') is-invalid @enderror me-2"
                                                    type="checkbox" id="terms">
                                                <label class="form-check-label" for="terms">
                                                    <span class="text-dark">Acepto los</span>
                                                    <a href="#" class="text-info fw-bold" data-bs-toggle="modal"
                                                        data-bs-target="#termsModal">Términos de uso</a>
                                                    <span>y</span>
                                                    <a href="#" class="text-info fw-bold" data-bs-toggle="modal" data-bs-target="#privacyModal">Aviso de privacidad</a>
                                                </label>
                                            </div>
                                        </div>
                                        @error('terms')
                                            <div class="invalid-feedback d-block text-center mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                            @if ($currentStep > 1)
                                <button type="button" wire:click="previousStep" class="text-white btn btn-secondary">
                                    <x-icon name="nav.back" class="me-2" /> Atrás
                                </button>
                            @else
                                <span></span>
                            @endif

                            @if ($currentStep < 4)
                                <button type="button" wire:click="nextStep" class="btn btn-primary">
                                    Siguiente <x-icon name="nav.forward" class="ms-2" />
                                </button>
                            @else
                                <button type="submit" class="btn btn-primary text-white" wire:loading.attr="disabled">
                                    <span wire:loading wire:target="register"
                                        class="spinner-border spinner-border-sm me-2"></span>
                                    <span wire:loading.remove wire:target="register">Registrar</span>
                                    <span wire:loading wire:target="register">Procesando...</span>
                                </button>
                            @endif
                        </div>
                    </form>
                    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel"
                        aria-hidden="true" wire:ignore.self>
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mapModalLabel">Confirma tu Ubicación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body p-0">
                                    <div wire:ignore class="w-100 min-vh-50">
                                        <div id="map" class="map-container" style="height: 400px; width: 100%;"></div>
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <p class="small text-muted mb-0">Arrastra el marcador rojo a la entrada de tu local.
                                    </p>
                                    <button type="button" class="btn btn-primary text-white" data-bs-dismiss="modal">
                                        <x-icon name="success" class="me-2" /> Confirmar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <span class="fw-normal">
                            ¿Ya tienes cuenta? <a href="{{ route('ff.auth.login') }}" class="fw-bold text-info">Inicia
                                Sesión</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-4 w-100" style="max-width: 500px;"> 
                     @include('partials.footer')
            </div>
        </div>
    </div>
</section>


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&loading=async&callback=initGoogleServices"
        async defer></script>

    <script>
        let map = null;
        let marker = null;
        let geocoder = null;
        let isGoogleLoaded = false;

        function initGoogleServices() {
            geocoder = new google.maps.Geocoder();
            isGoogleLoaded = true;
            console.log("Google Maps Services Ready");
        }

        function openAndInitMap() {
            if (!isGoogleLoaded) return;

            const lat = @this.get('latitude') || 19.432608;
            const lng = @this.get('longitude') || -99.133209;
            const myLatlng = { lat: parseFloat(lat), lng: parseFloat(lng) };
            const mapEl = document.getElementById("map");

            if (!map || mapEl.innerHTML.trim() === "") {
                map = new google.maps.Map(mapEl, {
                    zoom: 15,
                    center: myLatlng,
                    streetViewControl: false,
                    mapTypeControl: false
                });

                marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    title: "Tu Ubicación"
                });

                marker.addListener("dragend", (event) => {
                    @this.set('latitude', event.latLng.lat(), true);
                    @this.set('longitude', event.latLng.lng(), true);
                });
            } else {

                google.maps.event.trigger(map, "resize");
                map.setCenter(myLatlng);
                marker.setPosition(myLatlng);
            }

            codeAddress();
        }

        function codeAddress() {
            if (!geocoder) return;

            const street = document.getElementById('street')?.value || '';
            const extNum = document.getElementById('extNumber')?.value || '';
            const zip = document.getElementById('zipCode')?.value || '';
            const city = document.getElementById('city')?.value || '';
            const municipality = document.getElementById('municipality')?.value || '';

            if (street.length > 2 && (zip.length === 5 || municipality.length > 2)) {
                const addressString = ${street} ${extNum}, ${municipality}, ${city}, ${zip}, Mexico;

                geocoder.geocode({ 'address': addressString }, function (results, status) {
                    if (status === 'OK') {
                        const location = results[0].geometry.location;

                        @this.set('latitude', location.lat(), true);
                        @this.set('longitude', location.lng(), true);

                        if (map) {
                            map.setCenter(location);
                            marker.setPosition(location);
                        }
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const mapModal = document.getElementById('mapModal');
            if (mapModal) {
                mapModal.addEventListener('shown.bs.modal', openAndInitMap);
            }

            Livewire.on('registration-success', (event) => {
                Swal.fire({
                    title: '¡Registro Exitoso!',
                    text: 'Tu cuenta ha sido creada. Por favor inicia sesión.',
                    icon: 'success',
                    confirmButtonColor: '#10B981',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = event.redirectUrl;
                });
            });
        });

        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', ({ component, el }) => {
                const streetInput = document.getElementById('street');
                if (streetInput) {
                    ['street', 'extNumber', 'zipCode'].forEach(id => {
                        const input = document.getElementById(id);
                        if (input && !input.dataset.hasGeocodeListener) {
                            input.addEventListener('blur', codeAddress);
                            input.dataset.hasGeocodeListener = "true";
                        }
                    });
                }
            });
        });
    </script>
@endpush
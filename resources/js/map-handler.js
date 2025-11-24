/**
 * Company: CETAM
 * Project: QPK
 * File: map-manager.js
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Definition of map-manager.js handling Leaflet map interaction and geolocation for parking creation. |
 *
 * - ID: 2 | Modified on: 23/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Fix for Leaflet rendering issues (invalidateSize) and geolocation triggering. |
 */

// Constants
const DEFAULT_LAT = 19.432607;
const DEFAULT_LNG = -99.133209;

/**
 * Validates if coordinates are within valid range.
 * @param {number} lat
 * @param {number} lng
 * @returns {boolean}
 */
const isValidLatLng = (lat, lng) => {
    if (isNaN(lat) || isNaN(lng)) return false;
    return lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180;
};

/**
 * Helper to update DOM inputs.
 * Includes check to prevent infinite loops but allows update if field is empty.
 * @param {number} lat
 * @param {number} lng
 */
const updateDomInputs = (lat, lng) => {
    const latInput = document.getElementById("latitude");
    const lngInput = document.getElementById("longitude");

    if (latInput && lngInput) {
        const currentLat = parseFloat(latInput.value);
        const currentLng = parseFloat(lngInput.value);

        // Update if value is empty (NaN) OR if it differs significantly from new value
        if (isNaN(currentLat) || Math.abs(currentLat - lat) > 0.000001) {
            latInput.value = Number(lat).toFixed(7);
            latInput.classList.remove('is-invalid');
        }
        
        if (isNaN(currentLng) || Math.abs(currentLng - lng) > 0.000001) {
            lngInput.value = Number(lng).toFixed(7);
            lngInput.classList.remove('is-invalid');
        }
    }
};

/**
 * Initializes the map logic.
 */
const initParkingMap = () => {
    const mapContainer = document.getElementById("map");
    if (!mapContainer || mapContainer.dataset.bound) return;

    mapContainer.dataset.bound = "true";

    // 1. Initialize Map
    const map = L.map("map").setView([DEFAULT_LAT, DEFAULT_LNG], 12);
    
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "&copy; OpenStreetMap contributors",
    }).addTo(map);

    // Fix visual glitch (grey tiles)
    setTimeout(() => { map.invalidateSize(); }, 250);

    // SINGLE SOURCE OF TRUTH FOR THE MARKER
    let activeMarker = null;

    /**
     * Central function to handle marker placement/movement.
     * @param {number} lat 
     * @param {number} lng 
     * @param {boolean} updateInputsBool - Whether to update text inputs
     */
    const setMarkerState = (lat, lng, updateInputsBool = true) => {
        if (!isValidLatLng(lat, lng)) return;

        // Move map center
        map.setView([lat, lng], 15);

        // Move or Create Marker
        if (activeMarker) {
            activeMarker.setLatLng([lat, lng]);
        } else {
            activeMarker = L.marker([lat, lng], { draggable: true }).addTo(map);
            
            // Listener: Dragging the marker updates inputs
            activeMarker.on("moveend", (e) => {
                const { lat: newLat, lng: newLng } = e.target.getLatLng();
                updateDomInputs(newLat, newLng);
            });
        }

        // Update Inputs (if requested)
        if (updateInputsBool) {
            updateDomInputs(lat, lng);
        }
    };

    // 2. Logic: Get Current Location
    const handleGeolocation = () => {
        if (!navigator.geolocation) {
            console.warn("Geolocation not supported.");
            return;
        }
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const { latitude, longitude } = pos.coords;
                // This triggers the input update and marker placement
                setMarkerState(latitude, longitude, true);
            },
            (err) => console.warn("Geolocation error or denied:", err.message),
            { enableHighAccuracy: true }
        );
    };

    // 3. Logic: Handle Manual Input Changes
    const handleManualInput = () => {
        const latInput = document.getElementById("latitude");
        const lngInput = document.getElementById("longitude");
        
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);

        if (isValidLatLng(lat, lng)) {
            // Valid: Move marker, NO need to overwrite inputs (prevents cursor jumping)
            setMarkerState(lat, lng, false);
            latInput.classList.remove('is-invalid');
            lngInput.classList.remove('is-invalid');
        } else {
            // Invalid: Show error style
            if (isNaN(lat)) latInput.classList.add('is-invalid');
            if (isNaN(lng)) lngInput.classList.add('is-invalid');
        }
    };

    // A. Initial Load: Check for existing values (e.g., validation error redirect) or geolocate
    const oldLat = parseFloat(document.getElementById("latitude")?.value);
    const oldLng = parseFloat(document.getElementById("longitude")?.value);

    if (isValidLatLng(oldLat, oldLng)) {
        setMarkerState(oldLat, oldLng, false);
    } else {
        // If fields are empty, try to fill them with Geolocation
        handleGeolocation();
    }

    // B. Map Click -> Move Marker & Update Inputs
    map.on("click", (e) => {
        setMarkerState(e.latlng.lat, e.latlng.lng, true);
    });

    // C. Button Click -> Geolocate & Update Inputs
    const btnGeo = document.getElementById("btn-current-location");
    if (btnGeo) {
        btnGeo.addEventListener("click", (e) => {
            e.preventDefault();
            handleGeolocation();
        });
    }

    // D. Manual Input -> Move Marker
    const latInput = document.getElementById("latitude");
    const lngInput = document.getElementById("longitude");
    if (latInput && lngInput) {
        // Use 'input' for real-time validation or 'change' for commit
        latInput.addEventListener("input", handleManualInput);
        lngInput.addEventListener("input", handleManualInput);
    }
};

// Expose to window for Mix
window.initParkingMap = initParkingMap;
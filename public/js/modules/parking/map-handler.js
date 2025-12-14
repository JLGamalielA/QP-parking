/******/ (() => { // webpackBootstrap
/*!*************************************!*\
  !*** ./resources/js/map-handler.js ***!
  \*************************************/
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
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of map-manager.js handling Leaflet map interaction and geolocation for parking creation |
 *
 * - ID: 2 | Modified on: 23/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Fix for Leaflet rendering issues (invalidateSize) and geolocation triggering |
 */

// Constants
var DEFAULT_LAT = 19.432607;
var DEFAULT_LNG = -99.133209;

/**
 * Validates if coordinates are within valid range.
 * @param {number} lat
 * @param {number} lng
 * @returns {boolean}
 */
var isValidLatLng = function isValidLatLng(lat, lng) {
  if (isNaN(lat) || isNaN(lng)) return false;
  return lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180;
};

/**
 * Helper to update DOM inputs.
 * Includes check to prevent infinite loops but allows update if field is empty.
 * @param {number} lat
 * @param {number} lng
 */
var updateDomInputs = function updateDomInputs(lat, lng) {
  var latInput = document.getElementById("latitude");
  var lngInput = document.getElementById("longitude");
  if (latInput && lngInput) {
    var currentLat = parseFloat(latInput.value);
    var currentLng = parseFloat(lngInput.value);

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
var initParkingMap = function initParkingMap() {
  var _document$getElementB, _document$getElementB2;
  var mapContainer = document.getElementById("map");
  if (!mapContainer || mapContainer.dataset.bound) return;
  mapContainer.dataset.bound = "true";

  // 1. Initialize Map
  var map = L.map("map").setView([DEFAULT_LAT, DEFAULT_LNG], 12);
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "&copy; OpenStreetMap contributors"
  }).addTo(map);

  // Fix visual glitch (grey tiles)
  setTimeout(function () {
    map.invalidateSize();
  }, 250);

  // SINGLE SOURCE OF TRUTH FOR THE MARKER
  var activeMarker = null;

  /**
   * Central function to handle marker placement/movement.
   * @param {number} lat 
   * @param {number} lng 
   * @param {boolean} updateInputsBool - Whether to update text inputs
   */
  var setMarkerState = function setMarkerState(lat, lng) {
    var updateInputsBool = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
    if (!isValidLatLng(lat, lng)) return;

    // Move map center
    map.setView([lat, lng], 15);

    // Move or Create Marker
    if (activeMarker) {
      activeMarker.setLatLng([lat, lng]);
    } else {
      activeMarker = L.marker([lat, lng], {
        draggable: true
      }).addTo(map);

      // Listener: Dragging the marker updates inputs
      activeMarker.on("moveend", function (e) {
        var _e$target$getLatLng = e.target.getLatLng(),
          newLat = _e$target$getLatLng.lat,
          newLng = _e$target$getLatLng.lng;
        updateDomInputs(newLat, newLng);
      });
    }

    // Update Inputs (if requested)
    if (updateInputsBool) {
      updateDomInputs(lat, lng);
    }
  };

  // 2. Logic: Get Current Location
  var handleGeolocation = function handleGeolocation() {
    if (!navigator.geolocation) {
      console.warn("Geolocation not supported.");
      return;
    }
    navigator.geolocation.getCurrentPosition(function (pos) {
      var _pos$coords = pos.coords,
        latitude = _pos$coords.latitude,
        longitude = _pos$coords.longitude;
      // This triggers the input update and marker placement
      setMarkerState(latitude, longitude, true);
    }, function (err) {
      return console.warn("Geolocation error or denied:", err.message);
    }, {
      enableHighAccuracy: true
    });
  };

  // 3. Logic: Handle Manual Input Changes
  var handleManualInput = function handleManualInput() {
    var latInput = document.getElementById("latitude");
    var lngInput = document.getElementById("longitude");
    var lat = parseFloat(latInput.value);
    var lng = parseFloat(lngInput.value);
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
  var oldLat = parseFloat((_document$getElementB = document.getElementById("latitude")) === null || _document$getElementB === void 0 ? void 0 : _document$getElementB.value);
  var oldLng = parseFloat((_document$getElementB2 = document.getElementById("longitude")) === null || _document$getElementB2 === void 0 ? void 0 : _document$getElementB2.value);
  if (isValidLatLng(oldLat, oldLng)) {
    setMarkerState(oldLat, oldLng, false);
  } else {
    // If fields are empty, try to fill them with Geolocation
    handleGeolocation();
  }

  // B. Map Click -> Move Marker & Update Inputs
  map.on("click", function (e) {
    setMarkerState(e.latlng.lat, e.latlng.lng, true);
  });

  // C. Button Click -> Geolocate & Update Inputs
  var btnGeo = document.getElementById("btn-current-location");
  if (btnGeo) {
    btnGeo.addEventListener("click", function (e) {
      e.preventDefault();
      handleGeolocation();
    });
  }

  // D. Manual Input -> Move Marker
  var latInput = document.getElementById("latitude");
  var lngInput = document.getElementById("longitude");
  if (latInput && lngInput) {
    // Use 'input' for real-time validation or 'change' for commit
    latInput.addEventListener("input", handleManualInput);
    lngInput.addEventListener("input", handleManualInput);
  }
};

// Expose to window for Mix
window.initParkingMap = initParkingMap;
/******/ })()
;
/******/ (() => { // webpackBootstrap
/*!**************************************!*\
  !*** ./resources/js/active-scans.js ***!
  \**************************************/
/**
 * Company: CETAM
 * Project: QPK
 * File: active-scans.js
 * Created on: 30/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Date: 30/11/2025
 *   Modified by: Daniel Yair Mendoza Alvarez
 *   Description: Handler for Active User QR Scans interactions, specifically the manual release confirmation. |
 */

/**
 * Triggers a SweetAlert2 confirmation dialog for the manual release of an entry.
 * Complies with Manual Section 8.4.1 (Question Alert) regarding administrative interventions.
 *
 * @param {string|number} id - The unique identifier of the active scan to release.
 */
var confirmRelease = function confirmRelease(id) {
  // Ensure SweetAlert2 is loaded
  if (typeof Swal === "undefined") {
    console.error("SweetAlert2 is not loaded.");
    return;
  }
  Swal.fire({
    title: "¿Liberar entrada manualmente?",
    // Microcopy: Clear question
    text: "Esta es una intervención administrativa. Se forzará la salida del usuario.",
    icon: "question",
    showCancelButton: true,
    // Institutional Colors (Table 2 & Section 8.4.1)
    confirmButtonColor: "#E11D48",
    // Danger (Action is administrative/forceful)
    cancelButtonColor: "#6B7280",
    // Neutral/Secondary
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar"
  }).then(function (result) {
    if (result.isConfirmed) {
      var formId = "release-form-".concat(id);
      var form = document.getElementById(formId);
      if (form) {
        form.submit();
      } else {
        console.error("Form with ID ".concat(formId, " not found."));
      }
    }
  });
};

// EXPORT TO WINDOW SCOPE
// This is required to access the function from the HTML 'onclick' attribute.
window.confirmRelease = confirmRelease;
/******/ })()
;
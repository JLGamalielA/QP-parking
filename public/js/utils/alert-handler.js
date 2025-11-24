/******/ (() => { // webpackBootstrap
/*!***************************************!*\
  !*** ./resources/js/alert-handler.js ***!
  \***************************************/
/**
 * Company: CETAM
 * Project: QPK
 * File: alert-handler.js
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Global handler for SweetAlert2 interactions (Confirmation dialogs).
 */

/**
 * Triggers a SweetAlert2 confirmation dialog for deletion actions.
 * Complies with Manual Section 8.4.5 (Question Alert) and Table 2 (Colors).
 * * @param {string|number} id - The unique identifier of the resource to delete.
 * @param {string} formIdPrefix - The prefix of the form ID (default: 'delete-form-').
 */
var confirmDelete = function confirmDelete(id) {
  var formIdPrefix = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "delete-form-";
  if (typeof Swal === "undefined") {
    console.error("SweetAlert2 is not loaded.");
    return;
  }
  Swal.fire({
    title: "¿Estás seguro?",
    // Microcopy Section 7.6
    text: "¡No podrás revertir esta acción!",
    icon: "warning",
    // Question/Warning type
    showCancelButton: true,
    // Institutional Colors (Table 2)
    confirmButtonColor: "#E11D48",
    // Danger Red
    cancelButtonColor: "#6B7280",
    // Neutral Gray
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar"
  }).then(function (result) {
    if (result.isConfirmed) {
      var form = document.getElementById("".concat(formIdPrefix).concat(id));
      if (form) {
        form.submit();
      } else {
        console.error("Form with ID ".concat(formIdPrefix).concat(id, " not found."));
      }
    }
  });
};

/**
 * Trigger a success alert toast/modal based on server session data.
 * @param {object} sessionData - The session object containing icon, title, text.
 */
var showSessionAlert = function showSessionAlert(sessionData) {
  if (typeof Swal === "undefined" || !sessionData) return;
  Swal.fire({
    icon: sessionData.icon,
    title: sessionData.title,
    text: sessionData.text,
    confirmButtonColor: "#1F2937",
    // Primary Color
    confirmButtonText: "Aceptar"
  });
};

// EXPORT TO WINDOW SCOPE (Required for Laravel Mix)
window.confirmDelete = confirmDelete;
window.showSessionAlert = showSessionAlert;
/******/ })()
;
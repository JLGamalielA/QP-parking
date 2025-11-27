/******/ (() => { // webpackBootstrap
/*!*********************************************!*\
  !*** ./resources/js/application-handler.js ***!
  \*********************************************/
/**
 * Company: CETAM
 * Project: QPK
 * File: application-handler.js
 * Created on: 26/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 26/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Handles interactions for Special User Applications (Approve/Reject). |
 */

var initApplicationHandlers = function initApplicationHandlers() {
  // Select all approve buttons
  var approveButtons = document.querySelectorAll(".btn-approve-request");
  if (approveButtons.length === 0) {
    return;
  }
  approveButtons.forEach(function (button) {
    // Prevent double binding
    if (button.dataset.bound === "true") {
      return;
    }
    button.dataset.bound = "true";
    button.addEventListener("click", function (e) {
      e.preventDefault();

      // Identify target form and input based on data-id
      var id = button.dataset.id;
      var form = document.getElementById("approve-form-".concat(id));
      var hiddenInputId = "end-date-".concat(id);

      // Date Calculations
      var todayObj = new Date();
      var todayStr = todayObj.toISOString().split("T")[0]; // YYYY-MM-DD

      // Calculate Max Date (Current Year + 2 years)
      var maxDateObj = new Date();
      maxDateObj.setFullYear(todayObj.getFullYear() + 2);
      var maxDateStr = maxDateObj.toISOString().split("T")[0];
      if (!form) {
        console.error("Form approve-form-".concat(id, " not found."));
        return;
      }

      // Check SweetAlert availability
      if (typeof Swal === "undefined") {
        console.error("SweetAlert2 is not loaded.");
        return;
      }
      Swal.fire({
        title: "Aprobar Solicitud",
        // Inject HTML with Min and Max date attributes
        html: "\n                    <p class=\"mb-3 text-gray-600\">Selecciona la fecha de vencimiento del permiso:</p>\n                    <input type=\"date\" \n                           id=\"swal-input-date\" \n                           class=\"form-control\" \n                           min=\"".concat(todayStr, "\" \n                           max=\"").concat(maxDateStr, "\">\n                    <small class=\"text-muted mt-2 d-block\">M\xE1ximo permitido hasta: ").concat(maxDateStr, "</small>\n                "),
        icon: "question",
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonColor: "#10B981",
        // Success Green
        cancelButtonColor: "#6B7280",
        // Neutral Gray
        confirmButtonText: "Aprobar",
        cancelButtonText: "Cancelar",
        preConfirm: function preConfirm() {
          var dateInput = document.getElementById("swal-input-date");
          var dateValue = dateInput.value;
          if (!dateValue) {
            Swal.showValidationMessage("Debes seleccionar una fecha");
            return false;
          }

          // Optional: Double check range validation in JS
          if (dateValue < todayStr || dateValue > maxDateStr) {
            Swal.showValidationMessage("La fecha debe estar entre hoy y ".concat(maxDateStr));
            return false;
          }
          return dateValue;
        }
      }).then(function (result) {
        if (result.isConfirmed && result.value) {
          var endDate = result.value;

          // Find the hidden input in the DOM
          var hiddenInput = document.getElementById(hiddenInputId);
          if (hiddenInput) {
            hiddenInput.value = endDate;
            form.submit();
          } else {
            console.error("Hidden input ".concat(hiddenInputId, " not found."));
          }
        }
      });
    });
  });

  // --- REJECT HANDLER ---
  var rejectButtons = document.querySelectorAll(".btn-reject-request");
  rejectButtons.forEach(function (btn) {
    if (btn.dataset.bound === "true") return;
    btn.dataset.bound = "true";
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      var id = btn.dataset.id;
      var formId = "reject-form-".concat(id);
      Swal.fire({
        title: "¿Rechazar solicitud?",
        text: "La solicitud será eliminada permanentemente.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#E11D48",
        // Danger Red
        cancelButtonColor: "#6B7280",
        confirmButtonText: "Sí, rechazar",
        cancelButtonText: "Cancelar"
      }).then(function (result) {
        if (result.isConfirmed) {
          document.getElementById(formId).submit();
        }
      });
    });
  });
};

// Initialize on standard load
document.addEventListener("DOMContentLoaded", function () {
  initApplicationHandlers();
});

// Export for manual re-initialization
window.initApplicationHandlers = initApplicationHandlers;
/******/ })()
;
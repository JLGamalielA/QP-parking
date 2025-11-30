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
  var approveButtons = document.querySelectorAll(".btn-approve-request");
  if (approveButtons.length > 0) {
    approveButtons.forEach(function (button) {
      if (button.dataset.bound === "true") return;
      button.dataset.bound = "true";
      button.addEventListener("click", function (e) {
        e.preventDefault();
        var id = button.dataset.id;
        var form = document.getElementById("approve-form-".concat(id));
        if (form) {
          // Submit directly without confirmation dialog
          form.submit();
        } else {
          console.error("Form approve-form-".concat(id, " not found."));
        }
      });
    });
  }
  var rejectButtons = document.querySelectorAll(".btn-reject-request");
  if (rejectButtons.length > 0) {
    rejectButtons.forEach(function (btn) {
      if (btn.dataset.bound === "true") return;
      btn.dataset.bound = "true";
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        var id = btn.dataset.id;
        var formId = "reject-form-".concat(id);
        [cite_start];
        if (typeof Swal !== "undefined") {
          Swal.fire({
            title: "¿Rechazar solicitud?",
            text: "La solicitud será eliminada permanentemente.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#E11D48",
            cancelButtonColor: "#6B7280",
            confirmButtonText: "Sí, rechazar",
            cancelButtonText: "Cancelar"
          }).then(function (result) {
            if (result.isConfirmed) {
              document.getElementById(formId).submit();
            }
          });
        }
      });
    });
  }
};
document.addEventListener("DOMContentLoaded", function () {
  initApplicationHandlers();
});
window.initApplicationHandlers = initApplicationHandlers;
/******/ })()
;
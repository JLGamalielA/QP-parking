/******/ (() => { // webpackBootstrap
/*!**********************************************!*\
  !*** ./resources/js/subscription-handler.js ***!
  \**********************************************/
/**
 * Company: CETAM
 * Project: QPK
 * File: subscription-handler.js
 * Created on: 30/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Date: 30/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Handler for subscription deactivation confirmation dialogs. |
 */

window.confirmDeactivation = function (userId) {
  Swal.fire({
    title: "¿Inactivar suscripción?",
    text: "El usuario perderá el acceso a las funciones de su plan inmediatamente.",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar",
    customClass: {
      confirmButton: "swal-danger-btn"
    }
  }).then(function (result) {
    if (result.isConfirmed) {
      var form = document.getElementById("deactivate-form-" + userId);
      if (form) {
        form.submit();
      } else {
        console.error("Formulario de desactivación no encontrado para el usuario: " + userId);
      }
    }
  });
};
/******/ })()
;
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
const confirmDelete = (id, formIdPrefix = "delete-form-") => {
    if (typeof Swal === "undefined") {
        console.error("SweetAlert2 is not loaded.");
        return;
    }

    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡No podrás revertir esta acción!",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        customClass: {
            confirmButton: "swal-danger-btn", 
        },
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById(`${formIdPrefix}${id}`);
            if (form) {
                form.submit();
            } else {
                console.error(`Form with ID ${formIdPrefix}${id} not found.`);
            }
        }
    });
};

/**
 * Trigger a success alert toast/modal based on server session data.
 * @param {object} sessionData - The session object containing icon, title, text.
 */
const showSessionAlert = (sessionData) => {
    if (typeof Swal === "undefined" || !sessionData) return;

    Swal.fire({
        icon: sessionData.icon,
        title: sessionData.title,
        text: sessionData.text,
        confirmButtonText: "Aceptar",
    });
};

// EXPORT TO WINDOW SCOPE (Required for Laravel Mix)
window.confirmDelete = confirmDelete;
window.showSessionAlert = showSessionAlert;

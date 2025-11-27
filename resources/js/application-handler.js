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

const initApplicationHandlers = () => {
    // Select all approve buttons
    const approveButtons = document.querySelectorAll(".btn-approve-request");

    if (approveButtons.length === 0) {
        return;
    }

    approveButtons.forEach((button) => {
        // Prevent double binding
        if (button.dataset.bound === "true") {
            return;
        }

        button.dataset.bound = "true";

        button.addEventListener("click", function (e) {
            e.preventDefault();

            // Identify target form and input based on data-id
            const id = button.dataset.id;
            const form = document.getElementById(`approve-form-${id}`);
            const hiddenInputId = `end-date-${id}`;

            // Date Calculations
            const todayObj = new Date();
            const todayStr = todayObj.toISOString().split("T")[0]; // YYYY-MM-DD

            // Calculate Max Date (Current Year + 2 years)
            const maxDateObj = new Date();
            maxDateObj.setFullYear(todayObj.getFullYear() + 2);
            const maxDateStr = maxDateObj.toISOString().split("T")[0];

            if (!form) {
                console.error(`Form approve-form-${id} not found.`);
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
                html: `
                    <p class="mb-3 text-gray-600">Selecciona la fecha de vencimiento del permiso:</p>
                    <input type="date" 
                           id="swal-input-date" 
                           class="form-control" 
                           min="${todayStr}" 
                           max="${maxDateStr}">
                    <small class="text-muted mt-2 d-block">Máximo permitido hasta: ${maxDateStr}</small>
                `,
                icon: "question",
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonColor: "#10B981", // Success Green
                cancelButtonColor: "#6B7280", // Neutral Gray
                confirmButtonText: "Aprobar",
                cancelButtonText: "Cancelar",
                preConfirm: () => {
                    const dateInput =
                        document.getElementById("swal-input-date");
                    const dateValue = dateInput.value;

                    if (!dateValue) {
                        Swal.showValidationMessage(
                            "Debes seleccionar una fecha"
                        );
                        return false;
                    }

                    // Optional: Double check range validation in JS
                    if (dateValue < todayStr || dateValue > maxDateStr) {
                        Swal.showValidationMessage(
                            `La fecha debe estar entre hoy y ${maxDateStr}`
                        );
                        return false;
                    }

                    return dateValue;
                },
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const endDate = result.value;

                    // Find the hidden input in the DOM
                    const hiddenInput = document.getElementById(hiddenInputId);

                    if (hiddenInput) {
                        hiddenInput.value = endDate;
                        form.submit();
                    } else {
                        console.error(
                            `Hidden input ${hiddenInputId} not found.`
                        );
                    }
                }
            });
        });
    });

    // --- REJECT HANDLER ---
    const rejectButtons = document.querySelectorAll(".btn-reject-request");

    rejectButtons.forEach((btn) => {
        if (btn.dataset.bound === "true") return;
        btn.dataset.bound = "true";

        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const id = btn.dataset.id;
            const formId = `reject-form-${id}`;

            Swal.fire({
                title: "¿Rechazar solicitud?",
                text: "La solicitud será eliminada permanentemente.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#E11D48", // Danger Red
                cancelButtonColor: "#6B7280",
                confirmButtonText: "Sí, rechazar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        });
    });
};

// Initialize on standard load
document.addEventListener("DOMContentLoaded", () => {
    initApplicationHandlers();
});

// Export for manual re-initialization
window.initApplicationHandlers = initApplicationHandlers;

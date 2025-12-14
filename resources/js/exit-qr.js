/**
 * Company: CETAM
 * Project: QPK
 * File: exit-qr.js
 * Created on: 10/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Date: 10/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Modal used for generating exit QR codes |
 * 
 */

window.generateExitQrDirectly = function (url) {
    const modalEl = document.getElementById("exitQrModal");
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    const container = document.getElementById("qrContainer");
    const messageEl = document.getElementById("qrSuccessMessage");
    const amountEl = document.getElementById("qrAmountDisplay");

    container.innerHTML =
        '<div class="spinner-border text-primary" role="status"></div>';
    messageEl.innerText = "Procesando salida...";
    amountEl.innerText = "";

    modal.show();

    fetch(url, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            Accept: "application/json",
            "Content-Type": "application/json",
        },
    })
        .then(async (response) => {
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(
                    errorData.error ||
                        `Error en el servidor (${response.status})`
                );
            }
            return response.json();
        })
        .then((data) => {
            container.innerHTML = data.html;
            messageEl.innerText = data.message;
            amountEl.innerText = "$" + data.amount;

            modalEl.addEventListener(
                "hidden.bs.modal",
                function () {
                    window.location.reload();
                },
                {
                    once: true,
                }
            );
        })
        .catch((error) => {
            console.error(error);
            modal.hide();
            Swal.fire({
                icon: "error",
                title: "Error",
                text: error.message,
                confirmButtonText: "Aceptar",
            }).then((result) => {
                window.location.reload();
            });
        });
};

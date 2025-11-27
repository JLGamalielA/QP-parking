/**
 * Company: CETAM
 * Project: QPK
 * File: scanner-handler.js
 * Created on: 24/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 24/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Module to handle Web Serial API interactions for QR Scanners. |
 */

const SCAN_COOLDOWN_MS = 3000;
let lastScanTime = 0;
let activeReaderContext = null;
let rememberedPort = null;

// --- UI Helper Functions ---

/**
 * Updates the table status text (Active/Inactive) with semantic colors.
 * @param {string} entryId - The ID of the parking entry.
 * @param {boolean} isActive - State to apply.
 */
const updateStatusText = (entryId, isActive) => {
    // Selector matches the new span class in Blade
    const statusSpan = document.querySelector(
        `.reader-status-text[data-entry-id="${entryId}"]`
    );
    if (!statusSpan) return;

    if (isActive) {
        statusSpan.textContent = "Activo";
        statusSpan.classList.remove("text-danger"); // Remove 'Inactivo' color
        statusSpan.classList.add("text-success"); // Add 'Activo' color
    } else {
        statusSpan.textContent = "Inactivo";
        statusSpan.classList.remove("text-success");
        statusSpan.classList.add("text-danger"); // Add 'Inactivo' color
    }
};

/**
 * Updates the dropdown item UI based on the active state.
 */
const setButtonState = (btn, isActive) => {
    const icon = btn.querySelector("i") || btn.querySelector("svg");
    const textSpan = btn.querySelector("span");
    const entryId = btn.dataset.entryId;

    // Sync the status text in the table row
    updateStatusText(entryId, isActive);

    if (isActive) {
        btn.dataset.qrActive = "1";

        // Visual: Active State (Warning Color for dropdown action 'Listening')
        btn.classList.remove("text-success");
        btn.classList.add("text-warning");

        if (textSpan) {
            textSpan.textContent = "Escuchando...";
        } else {
            btn.childNodes.forEach((node) => {
                if (node.nodeType === 3 && node.textContent.trim().length > 0) {
                    node.textContent = "Escuchando...";
                }
            });
        }

        if (icon) {
            if (!btn.dataset.originalIcon)
                btn.dataset.originalIcon = icon.className;
            icon.className = "fas fa-cog fa-spin me-2";
        }
    } else {
        btn.dataset.qrActive = "0";

        // Visual: Inactive State (Success Color for dropdown action 'Activate')
        btn.classList.remove("text-warning");
        btn.classList.add("text-success");

        if (textSpan) {
            textSpan.textContent = "Activar";
        } else {
            btn.childNodes.forEach((node) => {
                if (node.nodeType === 3 && node.textContent.trim().length > 0) {
                    node.textContent = "Activar";
                }
            });
        }

        if (icon && btn.dataset.originalIcon) {
            icon.className = btn.dataset.originalIcon;
        }
    }
};

const displayOutput = (message, isError = false) => {
    const output = document.getElementById("qr-output");
    if (!output) return;

    output.textContent = message;
    output.style.whiteSpace = "pre-wrap";
    output.className = isError
        ? "mt-3 px-3 text-center fw-bold text-danger"
        : "mt-3 px-3 text-center fw-bold text-success";
};

// --- Serial API Logic ---

const deactivateCurrentReader = async () => {
    if (!activeReaderContext) return;

    const { button, port, reader, inputDone } = activeReaderContext;
    activeReaderContext.stopRequested = true;

    try {
        if (reader) {
            await reader.cancel();
            reader.releaseLock();
        }
        if (inputDone) await inputDone.catch(() => {});
        if (port) await port.close();
    } catch (e) {
        console.warn("Error closing scanner resources:", e);
    } finally {
        setButtonState(button, false);
        activeReaderContext = null;
        displayOutput("");
    }
};

const processScanData = async (code, url, parkingId, entryId, token) => {
    displayOutput("Procesando código...", false);

    try {
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token,
                Accept: "application/json",
            },
            body: JSON.stringify({
                code: code,
                parking_id: parkingId,
                entry_id: entryId,
            }),
        });

        const json = await response.json();

        if (response.ok && json.ok) {
            const type = json.data.action === "entry" ? "Entrada" : "Salida";
            const timestamp = new Date().toLocaleTimeString();

            displayOutput(
                `Éxito: ${type} registrada. Usuario: ${json.data.code} a las ${timestamp}`,
                false
            );
        } else {
            let msg = "Error desconocido";

            if (json.error) {
                msg = json.error;
            } else if (json.message) {
                msg = json.message;
                if (json.errors && json.errors.code) {
                    msg += ` (${json.errors.code[0]})`;
                }
            } else if (json.data && json.data.error) {
                msg = json.data.error;
            }

            displayOutput(`Error: ${msg}`, true);
        }
    } catch (e) {
        console.error("API Communication Error:", e);
        displayOutput("Error de comunicación con el servidor.", true);
    }
};

const initScanner = async (btn) => {
    if (btn.dataset.qrActive === "1") {
        await deactivateCurrentReader();
        return;
    }

    if (activeReaderContext && activeReaderContext.button !== btn) {
        await deactivateCurrentReader();
    }

    const storeUrl = btn.dataset.storeUrl;
    const parkingId = btn.dataset.parkingId;
    const entryId = btn.dataset.entryId;
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute("content") : "";

    if (!storeUrl || !parkingId || !entryId) {
        console.error("Missing data attributes on scanner button");
        return;
    }

    try {
        let port;
        try {
            if (rememberedPort) {
                port = rememberedPort;
                await port.open({ baudRate: 9600 });
            } else {
                port = await navigator.serial.requestPort();
                rememberedPort = port;
                await port.open({ baudRate: 9600 });
            }
        } catch (e) {
            try {
                port = await navigator.serial.requestPort();
                rememberedPort = port;
                await port.open({ baudRate: 9600 });
            } catch (innerE) {
                return;
            }
        }

        const decoder = new TextDecoderStream();
        const inputDone = port.readable.pipeTo(decoder.writable);
        const inputStream = decoder.readable;
        const reader = inputStream.getReader();

        setButtonState(btn, true);
        displayOutput("Lector conectado. Esperando código...", false);

        activeReaderContext = {
            button: btn,
            port,
            reader,
            inputDone,
            stopRequested: false,
        };

        while (
            activeReaderContext &&
            !activeReaderContext.stopRequested &&
            activeReaderContext.button === btn
        ) {
            const { value, done } = await reader.read();
            if (done) break;

            if (value) {
                const code = value.trim();
                if (code.length > 0) {
                    const now = Date.now();
                    if (now - lastScanTime > SCAN_COOLDOWN_MS) {
                        lastScanTime = now;
                        await processScanData(
                            code,
                            storeUrl,
                            parkingId,
                            entryId,
                            csrfToken
                        );
                    }
                }
            }
        }
    } catch (error) {
        console.error("Scanner System Error:", error);
        alert(
            "No se pudo conectar al lector. Verifique permisos y conexión USB."
        );
        await deactivateCurrentReader();
    }
};

const bindQrReaderButtons = () => {
    const buttons = document.querySelectorAll(".btn-activate-reader");

    if (buttons.length === 0) return;

    buttons.forEach((btn) => {
        if (btn.dataset.bound === "true") return;

        btn.dataset.bound = "true";
        btn.dataset.qrActive = "0";

        btn.addEventListener("click", (e) => {
            initScanner(btn);
        });
    });
};

document.addEventListener("DOMContentLoaded", () => {
    bindQrReaderButtons();
});

window.initScannerBinding = bindQrReaderButtons;

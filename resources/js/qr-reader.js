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

const updateStatusText = (entryId, isActive) => {
    const statusSpan = document.querySelector(
        `.reader-status-text[data-entry-id="${entryId}"]`
    );
    if (!statusSpan) return;

    if (isActive) {
        statusSpan.textContent = "Activo";
        statusSpan.classList.remove("text-warning");
        statusSpan.classList.add("text-success");
    } else {
        statusSpan.textContent = "Inactivo";
        statusSpan.classList.remove("text-success");
        statusSpan.classList.add("text-warning");
    }
};

const setButtonState = (btn, isActive) => {
    const icon = btn.querySelector("i") || btn.querySelector("svg");
    const textSpan = btn.querySelector("span");
    const entryId = btn.dataset.entryId;

    updateStatusText(entryId, isActive);

    if (isActive) {
        btn.dataset.qrActive = "1";
        btn.classList.remove("text-success");
        btn.classList.add("text-warning");

        if (textSpan) textSpan.textContent = "Desactivar";
        if (icon) icon.className = "fa-solid fa-xmark me-2";
    } else {
        btn.dataset.qrActive = "0";
        btn.classList.remove("text-warning");
        btn.classList.add("text-success");

        if (textSpan) textSpan.textContent = "Activar";
        if (icon && btn.dataset.originalIcon)
            icon.className = btn.dataset.originalIcon;
    }
};

const displayOutput = (message, isError = false) => {
    const output = document.getElementById("qr-output");
    if (!output) return;
    output.textContent = message;
    output.className = isError
        ? "mt-3 px-3 text-center fw-bold text-danger"
        : "mt-3 px-3 text-center fw-bold text-success";
};

// Serial API Logic with Buffer
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
    // Validate code length or format if necessary to avoid sending garbage
    if (code.length < 1) return;

    displayOutput(`Procesando código...`, false);

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
            if (json.data.action === "exitToken") {
                displayOutput("Éxito: Salida registrada.", false);
            } else if (json.data.action === "exit") {
                const info = json.data;
                const msg = `Salida Exitosa. Usuario: ${info.code}. Hora de salida: ${info.exit_time}. Cobrado: $${info.amount_paid}. Crédito restante: $${info.new_credit}`;
                displayOutput(msg, false);
            } else {
                const timestamp = new Date().toLocaleTimeString();
                displayOutput(
                    `Éxito: Entrada registrada. Usuario: ${json.data.code} a las ${timestamp}`,
                    false
                );
            }
        } else {
            let msg =
                json.error ||
                json.message ||
                (json.data && json.data.error) ||
                "Error desconocido";
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
    const csrfToken =
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content") || "";

    if (!storeUrl || !parkingId || !entryId) {
        console.error("Missing data attributes on scanner button");
        return;
    }

    try {
        let port;
        if (rememberedPort) {
            port = rememberedPort;
        } else {
            port = await navigator.serial.requestPort();
            rememberedPort = port;
        }

        await port.open({ baudRate: 9600 });

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

        /**
         Buffering logic
          Accumulates characters
         *  */
        let buffer = "";
        let bufferTimeout = null;

        const processBuffer = async () => {
            if (buffer.length > 0) {
                const code = buffer.replace(/[\x00-\x1F\x7F]/g, "").trim();
                // Reset buffer
                buffer = "";

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
        };

        while (
            activeReaderContext &&
            !activeReaderContext.stopRequested &&
            activeReaderContext.button === btn
        ) {
            const { value, done } = await reader.read();
            if (done) break;

            if (value) {
                if (bufferTimeout) clearTimeout(bufferTimeout);

                buffer += value;

                if (buffer.includes("\n") || buffer.includes("\r")) {
                    await processBuffer();
                } else {
                    bufferTimeout = setTimeout(async () => {
                        await processBuffer();
                    }, 300);
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
        // Store original icon for restoring state
        const icon = btn.querySelector("i") || btn.querySelector("svg");
        if (icon) btn.dataset.originalIcon = icon.className;

        btn.addEventListener("click", () => initScanner(btn));
    });
};

document.addEventListener("DOMContentLoaded", () => {
    bindQrReaderButtons();
});

window.initScannerBinding = bindQrReaderButtons;

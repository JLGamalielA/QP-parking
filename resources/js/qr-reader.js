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

const setButtonState = (btn, isActive) => 
    {
        const span = btn.querySelector("span") || btn;

        if (isActive) {
            btn.dataset.qrActive = "1";
            // Using Volt/Bootstrap classes via classList
            btn.classList.remove("btn-primary");
            btn.classList.add("btn-warning"); // Visual indicator for ACTIVE state
            span.textContent = "Activado (Escuchando...)";
        } else {
            btn.dataset.qrActive = "0";
            btn.classList.remove("btn-warning");
            btn.classList.add("btn-primary");
            span.textContent = "Activar Lector";
        }
    };

const displayOutput = (message, isError = false) => {
    const output = document.getElementById("qr-output");
    if (!output) return;

    output.textContent = message;
    output.className = isError
        ? "mt-2 text-danger fw-bold"
        : "mt-2 text-success fw-bold";
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
        if (inputDone) await inputDone.catch(() => {}); // Ignore stream errors on close
        if (port) await port.close();
    } catch (e) {
        console.warn("Error closing scanner resources:", e);
    } finally {
        setButtonState(button, false);
        activeReaderContext = null;
    }
};

const initScanner = async (btn) => {
    // Deactivate if already active
    if (btn.dataset.qrActive === "1") {
        await deactivateCurrentReader();
        return;
    }

    // Deactivate any other active reader first
    if (activeReaderContext && activeReaderContext.button !== btn) {
        await deactivateCurrentReader();
    }

    // Configuration Data from DOM
    const storeUrl = btn.dataset.storeUrl;
    const parkingId = btn.dataset.parkingId;
    const entryId = btn.dataset.entryId;
    // Retrieve CSRF token from meta tag (Standard Laravel)
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    try {
        let port;
        if (rememberedPort) {
            port = rememberedPort;
            await port.open({ baudRate: 9600 });
        } else {
            port = await navigator.serial.requestPort();
            rememberedPort = port;
            await port.open({ baudRate: 9600 });
        }

        const decoder = new TextDecoderStream();
        const inputDone = port.readable.pipeTo(decoder.writable);
        const reader = decoder.readable.getReader();

        // Update UI to Active
        setButtonState(btn, true);

        // Set Context
        activeReaderContext = {
            button: btn,
            port,
            reader,
            inputDone,
            stopRequested: false,
        };

        // Reading Loop
        while (activeReaderContext && !activeReaderContext.stopRequested) {
            const { value, done } = await reader.read();
            if (done) break;

            if (value) {
                const code = value.trim();
                if (code.length > 0) {
                    const now = Date.now();
                    // Cooldown check
                    if (now - lastScanTime > SCAN_COOLDOWN_MS) {
                        lastScanTime = now;
                        processScanData(
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
        console.error("Scanner Error:", error);
        alert("No se pudo conectar al lector. Verifica permisos.");
        await deactivateCurrentReader();
    }
};

const processScanData = async (code, url, parkingId, entryId, token) => {
    displayOutput("Procesando...", false);

    try {
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token,
                Accept: "application/json",
            },
            body: JSON.stringify({
                code,
                parking_id: parkingId,
                entry_id: entryId,
            }),
        });

        const data = await response.json();

        if (response.ok) {
            displayOutput(`${data.message}`, false);
            // Optional: Emit event to refresh a livewire table if needed
            // Livewire.dispatch('scan-processed');
        } else {
            displayOutput(`Error: ${data.error.message}`, true);
        }
    } catch (e) {
        console.error("API Error:", e);
        displayOutput("Error de comunicación con el servidor.", true);
    }
};

// --- Export for Global Usage ---
window.initScannerBinding = () => {
    const buttons = document.querySelectorAll(".btn-activate-scanner");
    buttons.forEach((btn) => {
        // Avoid double binding
        if (btn.dataset.bound === "true") return;
        btn.dataset.bound = "true";

        btn.addEventListener("click", () => initScanner(btn));
    });
};

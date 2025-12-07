/**
 * Company: CETAM
 * Project: QPK
 * File: form-handler.js
 * Created on: 02/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Date: 02/12/2025
 *   Modified by: Daniel Yair Mendoza Alvarez
 *   Description: script handles the initialization of the parking form,
 *   including toggling visibility of price fields based on parking type selection.
 */

const { reset } = require("laravel-mix/src/Log");

const initParkingFormLogic = () => {
    const typeSelect = document.getElementById("type");
    const hourlyContainer = document.getElementById("hourly-container");
    const fixedContainer = document.getElementById("fixed-container");

    // Inputs
    const hourlyInput = document.getElementById("price_per_hour");
    const fixedInput = document.getElementById("fixed_price");

    if (!typeSelect || !hourlyContainer || !fixedContainer) {
        return;
    }

    const resetInput = (input) => {
        if (input) {
            input.value = "";
            input.classList.remove("is-invalid");
        }
    };

    const restoreInput = (input) => {
        if (input && input.dataset.originalValue && input.value === "") {
            input.value = input.dataset.originalValue;
        }
    };

    /**
     * Logic to toggle visibility and clear values
     */
    const toggleFields = () => {
        const selectedType = typeSelect.value;

        // Reset visibility first (add d-none to both)
        hourlyContainer.classList.add("d-none");
        fixedContainer.classList.add("d-none");

        switch (selectedType) {
            case "hour":
                hourlyContainer.classList.remove("d-none");
                restoreInput(hourlyInput);
                resetInput(fixedInput);
                break;

            case "static":
                fixedContainer.classList.remove("d-none");
                restoreInput(fixedInput);
                resetInput(hourlyInput);
                break;

            case "mixed":
                hourlyContainer.classList.remove("d-none");
                fixedContainer.classList.remove("d-none");
                restoreInput(hourlyInput);
                restoreInput(fixedInput);
                break;

            default:
                break;
        }
    };

    // 2. Add Event Listener
    typeSelect.addEventListener("change", toggleFields);

    // 3. Trigger immediately
    toggleFields();
};

document.addEventListener("DOMContentLoaded", initParkingFormLogic);

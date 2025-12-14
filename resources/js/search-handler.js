/**
 * Company: CETAM
 * Project: QPK
 * File: search-handler.js
 * Created on: 26/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 26/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Module to handle search input validations (prevent spaces, max length enforcement) |
 */

const initSearchHandlers = () => {
    const searchInputs = document.querySelectorAll(".search-input");

    if (searchInputs.length === 0) return;

    searchInputs.forEach((input) => {
        // Prevent entering spaces via keyboard
        input.addEventListener("keypress", function (e) {
            if (e.key === " ") {
                e.preventDefault();
            }
        });

        // Remove spaces if pasted from clipboard
        input.addEventListener("input", function (e) {
            this.value = this.value.replace(/\s/g, "");
        });
    });
};

// Initialize on load
document.addEventListener("DOMContentLoaded", () => {
    initSearchHandlers();
});

// Export for dynamic re-initialization (e.g. Livewire)
window.initSearchBinding = initSearchHandlers;

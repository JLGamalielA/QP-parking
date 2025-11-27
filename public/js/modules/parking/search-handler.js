/******/ (() => { // webpackBootstrap
/*!****************************************!*\
  !*** ./resources/js/search-handler.js ***!
  \****************************************/
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
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Module to handle search input validations (prevent spaces, max length enforcement).
 */

var initSearchHandlers = function initSearchHandlers() {
  var searchInputs = document.querySelectorAll(".search-input");
  if (searchInputs.length === 0) return;
  searchInputs.forEach(function (input) {
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

    // Optional: Enforce numeric only if phone search is strict
    // input.addEventListener('input', function(e) {
    //     this.value = this.value.replace(/[^0-9]/g, '');
    // });
  });
};

// Initialize on load
document.addEventListener("DOMContentLoaded", function () {
  initSearchHandlers();
});

// Export for dynamic re-initialization (e.g. Livewire)
window.initSearchBinding = initSearchHandlers;
/******/ })()
;
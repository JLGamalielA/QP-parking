/**
 * Company: CETAM
 * Project: QPK
 * File: index.js
 * Created on: 02/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Date: 02/12/2025
 *   Modified by: Daniel Yair Mendoza Alvarez
 *   Description: script handles the initialization of the dashboard view, 
 *   including chart setup using data attributes passed from Blade and binding event listeners for filters.
 */

document.addEventListener("DOMContentLoaded", () => {
    const chartContainer = document.getElementById("parking-income-chart");
    const filterSelect = document.getElementById("chart-period-select");

    // 1. Initialize Chart with Data from DOM
    if (chartContainer) {
        try {
            // Parse JSON data injected via data attributes
            const initialSeries = JSON.parse(
                chartContainer.dataset.series || "[]"
            );
            const initialCategories = JSON.parse(
                chartContainer.dataset.categories || "[]"
            );

            // Call the global initialization function defined in income-chart.js
            if (typeof window.initIncomeChart === "function") {
                window.initIncomeChart({
                    series: initialSeries,
                    categories: initialCategories,
                });
            }
        } catch (error) {
            console.error("Error parsing chart initial data:", error);
        }
    }

    // 2. Bind Filter Change Event
    if (filterSelect && chartContainer) {
        filterSelect.addEventListener("change", function () {
            const period = this.value;
            const url = chartContainer.dataset.url;

            // Call the global update function defined in income-chart.js
            if (typeof window.updateIncomeChart === "function") {
                window.updateIncomeChart(period, url);
            }
        });
    }
});

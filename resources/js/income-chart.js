/**
 * Company: CETAM
 * Project: QPK
 * File: income-chart.js
 * Created on: 02/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Date: 02/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Logic for initializing the income summary chart |
 *
 * - ID: 2 | Date: 02/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Changed chart type from Stacked to Standard Area (Overlay) to prevent visual misinterpretation of data magnitude |
 */

let incomeChartInstance = null;

/**
 * Initializes the Income Chart with initial data.
 * @param {Object} data - Contains 'series' and 'categories'.
 */
const initIncomeChart = (data) => {
    const chartElement = document.getElementById("parking-income-chart");

    if (chartElement && typeof ApexCharts !== "undefined") {
        if (incomeChartInstance) {
            incomeChartInstance.destroy();
        }

        chartElement.innerHTML = "";

        const options = {
            chart: {
                height: 350,
                type: "line",
                fontFamily: "Nunito Sans, sans-serif",
                stacked: false,
                toolbar: { show: false },
                zoom: { enabled: false },
                animations: { enabled: true },
            },
            series: data.series,
            xaxis: {
                categories: data.categories,
                type: "category",
                labels: {
                    style: {
                        colors: "#9CA3AF",
                        fontSize: "12px",
                        fontFamily: "Nunito Sans, sans-serif",
                    },
                    rotate: -45,
                    trim: false,
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                labels: {
                    style: {
                        colors: "#9CA3AF",
                        fontSize: "12px",
                        fontFamily: "Nunito Sans, sans-serif",
                    },
                    formatter: function (value) {
                        return "$" + parseFloat(value).toFixed(2);
                    },
                },
            },
            // 1. Normal: #6B7280 (Gray-500)
            // 2. Special: #FF8832 (Secondary)
            // 3. Total: #2361CE 
            colors: ["#6B7280", "#FF8832", "#2361CE"],

            fill: {
                type: ["gradient", "gradient", "solid"],
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 90, 100],
                },
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: "smooth",
                width: [2, 2, 4],
                dashArray: [0, 0, 0],
            },
            grid: {
                borderColor: "#F2F4F6",
                strokeDashArray: 4,
                yaxis: { lines: { show: true } },
            },
            tooltip: {
                theme: "light",
                shared: true,
                intersect: false,
                y: {
                    formatter: function (val) {
                        return "$" + parseFloat(val).toFixed(2);
                    },
                },
            },
            legend: {
                show: true,
                position: "top",
                horizontalAlign: "left",
                fontFamily: "Nunito Sans, sans-serif",
                fontSize: "13px",
                fontWeight: 600,
                labels: {
                    colors: "#4B5563",
                    useSeriesColors: false,
                },
                markers: {
                    width: 12,
                    height: 12,
                    strokeWidth: 0,
                    radius: 12,
                    offsetX: -2,
                    offsetY: 0,
                },
                itemMargin: {
                    horizontal: 15,
                    vertical: 0,
                },
                onItemClick: {
                    toggleDataSeries: true,
                },
                onItemHover: {
                    highlightDataSeries: true,
                },
            },
        };

        incomeChartInstance = new ApexCharts(chartElement, options);
        incomeChartInstance.render();
    }
};

/**
 * Updates the chart data AND cards via AJAX based on the selected period.
 * @param {string} period - 'day', 'week', 'month'
 * @param {string} url - The endpoint URL
 */
const updateIncomeChart = async (period, url) => {
    if (!incomeChartInstance) return;

    try {
        const response = await fetch(`${url}?period=${period}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        });

        if (!response.ok) throw new Error("Network response was not ok");

        const data = await response.json();

        // 1. UPDATE CHART (Accessing .chart property)
        await incomeChartInstance.updateSeries(data.chart.series);
        await incomeChartInstance.updateOptions({
            xaxis: {
                categories: data.chart.categories,
            },
        });

        // 2. UPDATE CARDS (Accessing .metrics property)
        const incomeElement = document.getElementById("card-income-value");
        const entriesElement = document.getElementById("card-entries-value");

        // Format currency (MXN/USD style)
        const currencyFmt = new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD",
            minimumFractionDigits: 2,
        });

        if (incomeElement) {
            incomeElement.textContent = currencyFmt.format(data.metrics.income);
        }

        if (entriesElement) {
            entriesElement.textContent = data.metrics.entries; 
        }
    } catch (error) {
        console.error("Error updating dashboard data:", error);
    }
};

// Export functions
window.initIncomeChart = initIncomeChart;
window.updateIncomeChart = updateIncomeChart;

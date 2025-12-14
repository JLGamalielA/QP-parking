/******/ (() => { // webpackBootstrap
/*!**************************************!*\
  !*** ./resources/js/income-chart.js ***!
  \**************************************/
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i["return"]) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); } r ? i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n : (o("next", 0), o("throw", 1), o("return", 2)); }, _regeneratorDefine2(e, r, n, t); }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
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

var incomeChartInstance = null;

/**
 * Initializes the Income Chart with initial data.
 * @param {Object} data - Contains 'series' and 'categories'.
 */
var initIncomeChart = function initIncomeChart(data) {
  var chartElement = document.getElementById("parking-income-chart");
  if (chartElement && typeof ApexCharts !== "undefined") {
    if (incomeChartInstance) {
      incomeChartInstance.destroy();
    }
    chartElement.innerHTML = "";
    var options = {
      chart: {
        height: 350,
        type: "line",
        fontFamily: "Nunito Sans, sans-serif",
        stacked: false,
        toolbar: {
          show: false
        },
        zoom: {
          enabled: false
        },
        animations: {
          enabled: true
        }
      },
      series: data.series,
      xaxis: {
        categories: data.categories,
        type: "category",
        labels: {
          style: {
            colors: "#9CA3AF",
            fontSize: "12px",
            fontFamily: "Nunito Sans, sans-serif"
          },
          rotate: -45,
          trim: false
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: "#9CA3AF",
            fontSize: "12px",
            fontFamily: "Nunito Sans, sans-serif"
          },
          formatter: function formatter(value) {
            return "$" + parseFloat(value).toFixed(2);
          }
        }
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
          stops: [0, 90, 100]
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: "smooth",
        width: [2, 2, 4],
        dashArray: [0, 0, 0]
      },
      grid: {
        borderColor: "#F2F4F6",
        strokeDashArray: 4,
        yaxis: {
          lines: {
            show: true
          }
        }
      },
      tooltip: {
        theme: "light",
        shared: true,
        intersect: false,
        y: {
          formatter: function formatter(val) {
            return "$" + parseFloat(val).toFixed(2);
          }
        }
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
          useSeriesColors: false
        },
        markers: {
          width: 12,
          height: 12,
          strokeWidth: 0,
          radius: 12,
          offsetX: -2,
          offsetY: 0
        },
        itemMargin: {
          horizontal: 15,
          vertical: 0
        },
        onItemClick: {
          toggleDataSeries: true
        },
        onItemHover: {
          highlightDataSeries: true
        }
      }
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
var updateIncomeChart = /*#__PURE__*/function () {
  var _ref = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee(period, url) {
    var response, data, incomeElement, entriesElement, currencyFmt, _t;
    return _regenerator().w(function (_context) {
      while (1) switch (_context.p = _context.n) {
        case 0:
          if (incomeChartInstance) {
            _context.n = 1;
            break;
          }
          return _context.a(2);
        case 1:
          _context.p = 1;
          _context.n = 2;
          return fetch("".concat(url, "?period=").concat(period), {
            headers: {
              "X-Requested-With": "XMLHttpRequest",
              Accept: "application/json"
            }
          });
        case 2:
          response = _context.v;
          if (response.ok) {
            _context.n = 3;
            break;
          }
          throw new Error("Network response was not ok");
        case 3:
          _context.n = 4;
          return response.json();
        case 4:
          data = _context.v;
          _context.n = 5;
          return incomeChartInstance.updateSeries(data.chart.series);
        case 5:
          _context.n = 6;
          return incomeChartInstance.updateOptions({
            xaxis: {
              categories: data.chart.categories
            }
          });
        case 6:
          // 2. UPDATE CARDS (Accessing .metrics property)
          incomeElement = document.getElementById("card-income-value");
          entriesElement = document.getElementById("card-entries-value"); // Format currency (MXN/USD style)
          currencyFmt = new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD",
            minimumFractionDigits: 2
          });
          if (incomeElement) {
            incomeElement.textContent = currencyFmt.format(data.metrics.income);
          }
          if (entriesElement) {
            entriesElement.textContent = data.metrics.entries;
          }
          _context.n = 8;
          break;
        case 7:
          _context.p = 7;
          _t = _context.v;
          console.error("Error updating dashboard data:", _t);
        case 8:
          return _context.a(2);
      }
    }, _callee, null, [[1, 7]]);
  }));
  return function updateIncomeChart(_x, _x2) {
    return _ref.apply(this, arguments);
  };
}();

// Export functions
window.initIncomeChart = initIncomeChart;
window.updateIncomeChart = updateIncomeChart;
/******/ })()
;
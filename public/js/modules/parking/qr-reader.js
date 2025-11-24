/******/ (() => { // webpackBootstrap
/*!***********************************!*\
  !*** ./resources/js/qr-reader.js ***!
  \***********************************/
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i["return"]) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); } r ? i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n : (o("next", 0), o("throw", 1), o("return", 2)); }, _regeneratorDefine2(e, r, n, t); }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
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

var SCAN_COOLDOWN_MS = 3000;
var lastScanTime = 0;
var activeReaderContext = null;
var rememberedPort = null;

// --- UI Helper Functions ---

var setButtonState = function setButtonState(btn, isActive) {
  var span = btn.querySelector("span") || btn;
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
var displayOutput = function displayOutput(message) {
  var isError = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
  var output = document.getElementById("qr-output");
  if (!output) return;
  output.textContent = message;
  output.className = isError ? "mt-2 text-danger fw-bold" : "mt-2 text-success fw-bold";
};

// --- Serial API Logic ---

var deactivateCurrentReader = /*#__PURE__*/function () {
  var _ref = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee() {
    var _activeReaderContext, button, port, reader, inputDone, _t;
    return _regenerator().w(function (_context) {
      while (1) switch (_context.p = _context.n) {
        case 0:
          if (activeReaderContext) {
            _context.n = 1;
            break;
          }
          return _context.a(2);
        case 1:
          _activeReaderContext = activeReaderContext, button = _activeReaderContext.button, port = _activeReaderContext.port, reader = _activeReaderContext.reader, inputDone = _activeReaderContext.inputDone;
          activeReaderContext.stopRequested = true;
          _context.p = 2;
          if (!reader) {
            _context.n = 4;
            break;
          }
          _context.n = 3;
          return reader.cancel();
        case 3:
          reader.releaseLock();
        case 4:
          if (!inputDone) {
            _context.n = 5;
            break;
          }
          _context.n = 5;
          return inputDone["catch"](function () {});
        case 5:
          if (!port) {
            _context.n = 6;
            break;
          }
          _context.n = 6;
          return port.close();
        case 6:
          _context.n = 8;
          break;
        case 7:
          _context.p = 7;
          _t = _context.v;
          console.warn("Error closing scanner resources:", _t);
        case 8:
          _context.p = 8;
          setButtonState(button, false);
          activeReaderContext = null;
          return _context.f(8);
        case 9:
          return _context.a(2);
      }
    }, _callee, null, [[2, 7, 8, 9]]);
  }));
  return function deactivateCurrentReader() {
    return _ref.apply(this, arguments);
  };
}();
var initScanner = /*#__PURE__*/function () {
  var _ref2 = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee2(btn) {
    var storeUrl, parkingId, entryId, csrfToken, port, decoder, inputDone, reader, _yield$reader$read, value, done, code, now, _t2;
    return _regenerator().w(function (_context2) {
      while (1) switch (_context2.p = _context2.n) {
        case 0:
          if (!(btn.dataset.qrActive === "1")) {
            _context2.n = 2;
            break;
          }
          _context2.n = 1;
          return deactivateCurrentReader();
        case 1:
          return _context2.a(2);
        case 2:
          if (!(activeReaderContext && activeReaderContext.button !== btn)) {
            _context2.n = 3;
            break;
          }
          _context2.n = 3;
          return deactivateCurrentReader();
        case 3:
          // Configuration Data from DOM
          storeUrl = btn.dataset.storeUrl;
          parkingId = btn.dataset.parkingId;
          entryId = btn.dataset.entryId; // Retrieve CSRF token from meta tag (Standard Laravel)
          csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
          _context2.p = 4;
          if (!rememberedPort) {
            _context2.n = 6;
            break;
          }
          port = rememberedPort;
          _context2.n = 5;
          return port.open({
            baudRate: 9600
          });
        case 5:
          _context2.n = 8;
          break;
        case 6:
          _context2.n = 7;
          return navigator.serial.requestPort();
        case 7:
          port = _context2.v;
          rememberedPort = port;
          _context2.n = 8;
          return port.open({
            baudRate: 9600
          });
        case 8:
          decoder = new TextDecoderStream();
          inputDone = port.readable.pipeTo(decoder.writable);
          reader = decoder.readable.getReader(); // Update UI to Active
          setButtonState(btn, true);

          // Set Context
          activeReaderContext = {
            button: btn,
            port: port,
            reader: reader,
            inputDone: inputDone,
            stopRequested: false
          };

          // Reading Loop
        case 9:
          if (!(activeReaderContext && !activeReaderContext.stopRequested)) {
            _context2.n = 12;
            break;
          }
          _context2.n = 10;
          return reader.read();
        case 10:
          _yield$reader$read = _context2.v;
          value = _yield$reader$read.value;
          done = _yield$reader$read.done;
          if (!done) {
            _context2.n = 11;
            break;
          }
          return _context2.a(3, 12);
        case 11:
          if (value) {
            code = value.trim();
            if (code.length > 0) {
              now = Date.now(); // Cooldown check
              if (now - lastScanTime > SCAN_COOLDOWN_MS) {
                lastScanTime = now;
                processScanData(code, storeUrl, parkingId, entryId, csrfToken);
              }
            }
          }
          _context2.n = 9;
          break;
        case 12:
          _context2.n = 14;
          break;
        case 13:
          _context2.p = 13;
          _t2 = _context2.v;
          console.error("Scanner Error:", _t2);
          alert("No se pudo conectar al lector. Verifica permisos.");
          _context2.n = 14;
          return deactivateCurrentReader();
        case 14:
          return _context2.a(2);
      }
    }, _callee2, null, [[4, 13]]);
  }));
  return function initScanner(_x) {
    return _ref2.apply(this, arguments);
  };
}();
var processScanData = /*#__PURE__*/function () {
  var _ref3 = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee3(code, url, parkingId, entryId, token) {
    var response, data, _t3;
    return _regenerator().w(function (_context3) {
      while (1) switch (_context3.p = _context3.n) {
        case 0:
          displayOutput("Procesando...", false);
          _context3.p = 1;
          _context3.n = 2;
          return fetch(url, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": token,
              Accept: "application/json"
            },
            body: JSON.stringify({
              code: code,
              parking_id: parkingId,
              entry_id: entryId
            })
          });
        case 2:
          response = _context3.v;
          _context3.n = 3;
          return response.json();
        case 3:
          data = _context3.v;
          if (response.ok) {
            displayOutput("".concat(data.message), false);
            // Optional: Emit event to refresh a livewire table if needed
            // Livewire.dispatch('scan-processed');
          } else {
            displayOutput("Error: ".concat(data.error.message), true);
          }
          _context3.n = 5;
          break;
        case 4:
          _context3.p = 4;
          _t3 = _context3.v;
          console.error("API Error:", _t3);
          displayOutput("Error de comunicación con el servidor.", true);
        case 5:
          return _context3.a(2);
      }
    }, _callee3, null, [[1, 4]]);
  }));
  return function processScanData(_x2, _x3, _x4, _x5, _x6) {
    return _ref3.apply(this, arguments);
  };
}();

// --- Export for Global Usage ---
window.initScannerBinding = function () {
  var buttons = document.querySelectorAll(".btn-activate-scanner");
  buttons.forEach(function (btn) {
    // Avoid double binding
    if (btn.dataset.bound === "true") return;
    btn.dataset.bound = "true";
    btn.addEventListener("click", function () {
      return initScanner(btn);
    });
  });
};
/******/ })()
;
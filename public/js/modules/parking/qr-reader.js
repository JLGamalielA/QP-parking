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

/**
 * Updates the table status text (Active/Inactive) with semantic colors.
 * @param {string} entryId - The ID of the parking entry.
 * @param {boolean} isActive - State to apply.
 */
var updateStatusText = function updateStatusText(entryId, isActive) {
  // Selector matches the new span class in Blade
  var statusSpan = document.querySelector(".reader-status-text[data-entry-id=\"".concat(entryId, "\"]"));
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
var setButtonState = function setButtonState(btn, isActive) {
  var icon = btn.querySelector("i") || btn.querySelector("svg");
  var textSpan = btn.querySelector("span");
  var entryId = btn.dataset.entryId;

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
      btn.childNodes.forEach(function (node) {
        if (node.nodeType === 3 && node.textContent.trim().length > 0) {
          node.textContent = "Escuchando...";
        }
      });
    }
    if (icon) {
      if (!btn.dataset.originalIcon) btn.dataset.originalIcon = icon.className;
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
      btn.childNodes.forEach(function (node) {
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
var displayOutput = function displayOutput(message) {
  var isError = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
  var output = document.getElementById("qr-output");
  if (!output) return;
  output.textContent = message;
  output.className = isError ? "mt-3 px-3 text-center fw-bold text-danger" : "mt-3 px-3 text-center fw-bold text-success";
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
          displayOutput("");
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
var processScanData = /*#__PURE__*/function () {
  var _ref2 = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee2(code, url, parkingId, entryId, token) {
    var response, json, type, timestamp, msg, _t2;
    return _regenerator().w(function (_context2) {
      while (1) switch (_context2.p = _context2.n) {
        case 0:
          displayOutput("Procesando código...", false);
          _context2.p = 1;
          _context2.n = 2;
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
          response = _context2.v;
          _context2.n = 3;
          return response.json();
        case 3:
          json = _context2.v;
          if (response.ok && json.ok) {
            type = json.data.action === "entry" ? "Entrada" : "Salida";
            timestamp = new Date().toLocaleTimeString();
            displayOutput("\xC9xito: ".concat(type, " registrada. Usuario: ").concat(json.data.code, " a las ").concat(timestamp), false);
          } else {
            msg = "Error desconocido";
            if (json.error) {
              msg = json.error;
            } else if (json.message) {
              msg = json.message;
              if (json.errors && json.errors.code) {
                msg += " (".concat(json.errors.code[0], ")");
              }
            } else if (json.data && json.data.error) {
              msg = json.data.error;
            }
            displayOutput("Error: ".concat(msg), true);
          }
          _context2.n = 5;
          break;
        case 4:
          _context2.p = 4;
          _t2 = _context2.v;
          console.error("API Communication Error:", _t2);
          displayOutput("Error de comunicación con el servidor.", true);
        case 5:
          return _context2.a(2);
      }
    }, _callee2, null, [[1, 4]]);
  }));
  return function processScanData(_x, _x2, _x3, _x4, _x5) {
    return _ref2.apply(this, arguments);
  };
}();
var initScanner = /*#__PURE__*/function () {
  var _ref3 = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee3(btn) {
    var storeUrl, parkingId, entryId, csrfMeta, csrfToken, port, decoder, inputDone, inputStream, reader, _yield$reader$read, value, done, code, now, _t3, _t4, _t5;
    return _regenerator().w(function (_context3) {
      while (1) switch (_context3.p = _context3.n) {
        case 0:
          if (!(btn.dataset.qrActive === "1")) {
            _context3.n = 2;
            break;
          }
          _context3.n = 1;
          return deactivateCurrentReader();
        case 1:
          return _context3.a(2);
        case 2:
          if (!(activeReaderContext && activeReaderContext.button !== btn)) {
            _context3.n = 3;
            break;
          }
          _context3.n = 3;
          return deactivateCurrentReader();
        case 3:
          storeUrl = btn.dataset.storeUrl;
          parkingId = btn.dataset.parkingId;
          entryId = btn.dataset.entryId;
          csrfMeta = document.querySelector('meta[name="csrf-token"]');
          csrfToken = csrfMeta ? csrfMeta.getAttribute("content") : "";
          if (!(!storeUrl || !parkingId || !entryId)) {
            _context3.n = 4;
            break;
          }
          console.error("Missing data attributes on scanner button");
          return _context3.a(2);
        case 4:
          _context3.p = 4;
          _context3.p = 5;
          if (!rememberedPort) {
            _context3.n = 7;
            break;
          }
          port = rememberedPort;
          _context3.n = 6;
          return port.open({
            baudRate: 9600
          });
        case 6:
          _context3.n = 9;
          break;
        case 7:
          _context3.n = 8;
          return navigator.serial.requestPort();
        case 8:
          port = _context3.v;
          rememberedPort = port;
          _context3.n = 9;
          return port.open({
            baudRate: 9600
          });
        case 9:
          _context3.n = 15;
          break;
        case 10:
          _context3.p = 10;
          _t3 = _context3.v;
          _context3.p = 11;
          _context3.n = 12;
          return navigator.serial.requestPort();
        case 12:
          port = _context3.v;
          rememberedPort = port;
          _context3.n = 13;
          return port.open({
            baudRate: 9600
          });
        case 13:
          _context3.n = 15;
          break;
        case 14:
          _context3.p = 14;
          _t4 = _context3.v;
          return _context3.a(2);
        case 15:
          decoder = new TextDecoderStream();
          inputDone = port.readable.pipeTo(decoder.writable);
          inputStream = decoder.readable;
          reader = inputStream.getReader();
          setButtonState(btn, true);
          displayOutput("Lector conectado. Esperando código...", false);
          activeReaderContext = {
            button: btn,
            port: port,
            reader: reader,
            inputDone: inputDone,
            stopRequested: false
          };
        case 16:
          if (!(activeReaderContext && !activeReaderContext.stopRequested && activeReaderContext.button === btn)) {
            _context3.n = 20;
            break;
          }
          _context3.n = 17;
          return reader.read();
        case 17:
          _yield$reader$read = _context3.v;
          value = _yield$reader$read.value;
          done = _yield$reader$read.done;
          if (!done) {
            _context3.n = 18;
            break;
          }
          return _context3.a(3, 20);
        case 18:
          if (!value) {
            _context3.n = 19;
            break;
          }
          code = value.trim();
          if (!(code.length > 0)) {
            _context3.n = 19;
            break;
          }
          now = Date.now();
          if (!(now - lastScanTime > SCAN_COOLDOWN_MS)) {
            _context3.n = 19;
            break;
          }
          lastScanTime = now;
          _context3.n = 19;
          return processScanData(code, storeUrl, parkingId, entryId, csrfToken);
        case 19:
          _context3.n = 16;
          break;
        case 20:
          _context3.n = 22;
          break;
        case 21:
          _context3.p = 21;
          _t5 = _context3.v;
          console.error("Scanner System Error:", _t5);
          alert("No se pudo conectar al lector. Verifique permisos y conexión USB.");
          _context3.n = 22;
          return deactivateCurrentReader();
        case 22:
          return _context3.a(2);
      }
    }, _callee3, null, [[11, 14], [5, 10], [4, 21]]);
  }));
  return function initScanner(_x6) {
    return _ref3.apply(this, arguments);
  };
}();
var bindQrReaderButtons = function bindQrReaderButtons() {
  var buttons = document.querySelectorAll(".btn-activate-reader");
  if (buttons.length === 0) return;
  buttons.forEach(function (btn) {
    if (btn.dataset.bound === "true") return;
    btn.dataset.bound = "true";
    btn.dataset.qrActive = "0";
    btn.addEventListener("click", function (e) {
      initScanner(btn);
    });
  });
};
document.addEventListener("DOMContentLoaded", function () {
  bindQrReaderButtons();
});
window.initScannerBinding = bindQrReaderButtons;
/******/ })()
;
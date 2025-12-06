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
var updateStatusText = function updateStatusText(entryId, isActive) {
  var statusSpan = document.querySelector(".reader-status-text[data-entry-id=\"".concat(entryId, "\"]"));
  if (!statusSpan) return;
  if (isActive) {
    statusSpan.textContent = "Activo";
    statusSpan.classList.remove("text-danger");
    statusSpan.classList.add("text-success");
  } else {
    statusSpan.textContent = "Inactivo";
    statusSpan.classList.remove("text-success");
    statusSpan.classList.add("text-danger");
  }
};
var setButtonState = function setButtonState(btn, isActive) {
  var icon = btn.querySelector("i") || btn.querySelector("svg");
  var textSpan = btn.querySelector("span");
  var entryId = btn.dataset.entryId;
  updateStatusText(entryId, isActive);
  if (isActive) {
    btn.dataset.qrActive = "1";
    btn.classList.remove("text-success");
    btn.classList.add("text-warning");
    if (textSpan) textSpan.textContent = "Escuchando...";
    if (icon) icon.className = "fas fa-cog fa-spin me-2";
  } else {
    btn.dataset.qrActive = "0";
    btn.classList.remove("text-warning");
    btn.classList.add("text-success");
    if (textSpan) textSpan.textContent = "Activar";
    if (icon && btn.dataset.originalIcon) icon.className = btn.dataset.originalIcon;
  }
};
var displayOutput = function displayOutput(message) {
  var isError = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
  var output = document.getElementById("qr-output");
  if (!output) return;
  output.textContent = message;
  output.className = isError ? "mt-3 px-3 text-center fw-bold text-danger" : "mt-3 px-3 text-center fw-bold text-success";
};

// Serial API Logic with Buffer
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
          if (!(code.length < 1)) {
            _context2.n = 1;
            break;
          }
          return _context2.a(2);
        case 1:
          displayOutput("Procesando c\xF3digo...", false);
          _context2.p = 2;
          _context2.n = 3;
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
        case 3:
          response = _context2.v;
          _context2.n = 4;
          return response.json();
        case 4:
          json = _context2.v;
          if (response.ok && json.ok) {
            type = json.data.action === "entry" ? "Entrada" : "Salida";
            timestamp = new Date().toLocaleTimeString();
            displayOutput("\xC9xito: ".concat(type, " registrada. Usuario: ").concat(json.data.code, " a las ").concat(timestamp), false);
          } else {
            msg = json.error || json.message || json.data && json.data.error || "Error desconocido";
            displayOutput("Error: ".concat(msg), true);
          }
          _context2.n = 6;
          break;
        case 5:
          _context2.p = 5;
          _t2 = _context2.v;
          console.error("API Communication Error:", _t2);
          displayOutput("Error de comunicación con el servidor.", true);
        case 6:
          return _context2.a(2);
      }
    }, _callee2, null, [[2, 5]]);
  }));
  return function processScanData(_x, _x2, _x3, _x4, _x5) {
    return _ref2.apply(this, arguments);
  };
}();
var initScanner = /*#__PURE__*/function () {
  var _ref3 = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee5(btn) {
    var _document$querySelect;
    var storeUrl, parkingId, entryId, csrfToken, port, decoder, inputDone, inputStream, reader, buffer, bufferTimeout, processBuffer, _yield$reader$read, value, done, _t3;
    return _regenerator().w(function (_context5) {
      while (1) switch (_context5.p = _context5.n) {
        case 0:
          if (!(btn.dataset.qrActive === "1")) {
            _context5.n = 2;
            break;
          }
          _context5.n = 1;
          return deactivateCurrentReader();
        case 1:
          return _context5.a(2);
        case 2:
          if (!(activeReaderContext && activeReaderContext.button !== btn)) {
            _context5.n = 3;
            break;
          }
          _context5.n = 3;
          return deactivateCurrentReader();
        case 3:
          storeUrl = btn.dataset.storeUrl;
          parkingId = btn.dataset.parkingId;
          entryId = btn.dataset.entryId;
          csrfToken = ((_document$querySelect = document.querySelector('meta[name="csrf-token"]')) === null || _document$querySelect === void 0 ? void 0 : _document$querySelect.getAttribute("content")) || "";
          if (!(!storeUrl || !parkingId || !entryId)) {
            _context5.n = 4;
            break;
          }
          console.error("Missing data attributes on scanner button");
          return _context5.a(2);
        case 4:
          _context5.p = 4;
          if (!rememberedPort) {
            _context5.n = 5;
            break;
          }
          port = rememberedPort;
          _context5.n = 7;
          break;
        case 5:
          _context5.n = 6;
          return navigator.serial.requestPort();
        case 6:
          port = _context5.v;
          rememberedPort = port;
        case 7:
          _context5.n = 8;
          return port.open({
            baudRate: 9600
          });
        case 8:
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

          /**
           Buffering logic
            Accumulates characters
           *  */
          buffer = "";
          bufferTimeout = null;
          processBuffer = /*#__PURE__*/function () {
            var _ref4 = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee3() {
              var code, now;
              return _regenerator().w(function (_context3) {
                while (1) switch (_context3.n) {
                  case 0:
                    if (!(buffer.length > 0)) {
                      _context3.n = 1;
                      break;
                    }
                    code = buffer.replace(/[\x00-\x1F\x7F]/g, "").trim(); // Reset buffer
                    buffer = "";
                    if (!(code.length > 0)) {
                      _context3.n = 1;
                      break;
                    }
                    now = Date.now();
                    if (!(now - lastScanTime > SCAN_COOLDOWN_MS)) {
                      _context3.n = 1;
                      break;
                    }
                    lastScanTime = now;
                    _context3.n = 1;
                    return processScanData(code, storeUrl, parkingId, entryId, csrfToken);
                  case 1:
                    return _context3.a(2);
                }
              }, _callee3);
            }));
            return function processBuffer() {
              return _ref4.apply(this, arguments);
            };
          }();
        case 9:
          if (!(activeReaderContext && !activeReaderContext.stopRequested && activeReaderContext.button === btn)) {
            _context5.n = 15;
            break;
          }
          _context5.n = 10;
          return reader.read();
        case 10:
          _yield$reader$read = _context5.v;
          value = _yield$reader$read.value;
          done = _yield$reader$read.done;
          if (!done) {
            _context5.n = 11;
            break;
          }
          return _context5.a(3, 15);
        case 11:
          if (!value) {
            _context5.n = 14;
            break;
          }
          if (bufferTimeout) clearTimeout(bufferTimeout);
          buffer += value;
          if (!(buffer.includes("\n") || buffer.includes("\r"))) {
            _context5.n = 13;
            break;
          }
          _context5.n = 12;
          return processBuffer();
        case 12:
          _context5.n = 14;
          break;
        case 13:
          bufferTimeout = setTimeout(/*#__PURE__*/_asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee4() {
            return _regenerator().w(function (_context4) {
              while (1) switch (_context4.n) {
                case 0:
                  _context4.n = 1;
                  return processBuffer();
                case 1:
                  return _context4.a(2);
              }
            }, _callee4);
          })), 300);
        case 14:
          _context5.n = 9;
          break;
        case 15:
          _context5.n = 17;
          break;
        case 16:
          _context5.p = 16;
          _t3 = _context5.v;
          console.error("Scanner System Error:", _t3);
          alert("No se pudo conectar al lector. Verifique permisos y conexión USB.");
          _context5.n = 17;
          return deactivateCurrentReader();
        case 17:
          return _context5.a(2);
      }
    }, _callee5, null, [[4, 16]]);
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
    // Store original icon for restoring state
    var icon = btn.querySelector("i") || btn.querySelector("svg");
    if (icon) btn.dataset.originalIcon = icon.className;
    btn.addEventListener("click", function () {
      return initScanner(btn);
    });
  });
};
document.addEventListener("DOMContentLoaded", function () {
  bindQrReaderButtons();
});
window.initScannerBinding = bindQrReaderButtons;
/******/ })()
;
"use strict";
(self["webpackChunkwordpress_plugin_boilerplate"] = self["webpackChunkwordpress_plugin_boilerplate"] || []).push([["/assets/js/plugin-name"],{

/***/ "./src/js/app.ts":
/*!***********************!*\
  !*** ./src/js/app.ts ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_forms_AuthForm__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/forms/AuthForm */ "./src/js/components/forms/AuthForm.js");


var PluginName = function () {
  function PluginName() {
    new _components_forms_AuthForm__WEBPACK_IMPORTED_MODULE_0__.AuthForm();
  }

  return PluginName;
}();

jQuery(function () {
  new PluginName();
});

/***/ }),

/***/ "./src/js/components/forms/AuthForm.js":
/*!*********************************************!*\
  !*** ./src/js/components/forms/AuthForm.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "AuthForm": () => (/* binding */ AuthForm)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _helpers_HttpHelper__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../helpers/HttpHelper */ "./src/js/helpers/HttpHelper.js");
/* harmony import */ var _helpers_helpers__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/helpers/helpers */ "./src/js/helpers/helpers.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var jqueryValidate = __webpack_require__(/*! jquery-validation */ "./node_modules/jquery-validation/dist/jquery.validate.js");



var AuthForm = /*#__PURE__*/function () {
  function AuthForm() {
    var useValidation = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

    _classCallCheck(this, AuthForm);

    this.formValidation = null;
    this.useValidation = useValidation; // this.formId = formId
    // this.formObj = jQuery(`#${formId}`)

    this.formAlertsClasss = 'form-alerts';
    this.formClass = 'auth-form';
    this.formObj = jQuery(".".concat(this.formClass));
    if (this.formObj.length === 0) return;

    if (this.useValidation) {
      this.formValidation = jqueryValidate(this.formObj);
      this.formValidation.validate();
      this.loadJqueryValidatorLocale();
    }

    this.registerEvents();
  }

  _createClass(AuthForm, [{
    key: "registerEvents",
    value: function registerEvents() {
      var _this = this;

      this.formObj.find(':input').on('keyup', function (e) {
        _this.formValidation.valid();
      });
      this.formObj.on('submit', function (e) {
        e.preventDefault();

        _this.sendForm(e);
      });
    }
  }, {
    key: "sendForm",
    value: function () {
      var _sendForm = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(event) {
        var form, formData, formAction, inputs, submitButton, container, notices, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                form = jQuery(event.target);
                formData = form.serialize();
                formAction = form.attr('action');
                inputs = form.find(':input');
                submitButton = form.find(':submit');
                container = form.parent();
                notices = container.find(".".concat(this.formAlertsClasss));

                if (!this.useValidation) {
                  _context.next = 10;
                  break;
                }

                if (this.formValidation.valid()) {
                  _context.next = 10;
                  break;
                }

                return _context.abrupt("return");

              case 10:
                console.log('form is valid', form, notices);
                notices.empty();
                inputs.prop('readonly', true);
                submitButton.prop('disabled', true);
                _context.prev = 14;
                _context.next = 17;
                return _helpers_HttpHelper__WEBPACK_IMPORTED_MODULE_1__.HttpHelper.post(formAction, formData);

              case 17:
                response = _context.sent;
                console.log("FORM .".concat(this.formClass, ", response"), response);
                inputs.prop('readonly', false);
                submitButton.prop('disabled', false);

                if (!response.success) {
                  notices.hide().html(response.data.errors).fadeIn();
                  _helpers_helpers__WEBPACK_IMPORTED_MODULE_2__["default"].scrollToElement(notices); // this.scrollToNotices(container)
                }

                if (response.data.successMsg) {
                  notices.hide().html(response.data.successMsg).fadeIn(); // this.scrollToNotices(container)

                  _helpers_helpers__WEBPACK_IMPORTED_MODULE_2__["default"].scrollToElement(notices);
                  form.trigger('reset');
                }

                _context.next = 31;
                break;

              case 25:
                _context.prev = 25;
                _context.t0 = _context["catch"](14);
                console.error('Error', _context.t0);
                inputs.prop('readonly', false);
                submitButton.prop('disabled', false);

                if (_context.t0.responseJSON && _context.t0.responseJSON.data) {
                  notices.hide().html(_context.t0.responseJSON.data.errors).fadeIn(); // this.scrollToNotices(container)

                  _helpers_helpers__WEBPACK_IMPORTED_MODULE_2__["default"].scrollToElement(notices);
                }

              case 31:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this, [[14, 25]]);
      }));

      function sendForm(_x) {
        return _sendForm.apply(this, arguments);
      }

      return sendForm;
    }()
  }, {
    key: "scrollToNotices",
    value: function scrollToNotices(container) {
      var notices = container.find(".".concat(this.formAlertsClasss));
      jQuery('html, body').stop().animate({
        scrollTop: notices.offset().top - 120
      }, 800, 'swing');
    }
  }, {
    key: "loadJqueryValidatorLocale",
    value: function loadJqueryValidatorLocale() {
      if (['de-DE', 'de-DE-formal'].includes(jQuery('html').attr('lang'))) {
        __webpack_require__(/*! jquery-validation/dist/localization/messages_de */ "./node_modules/jquery-validation/dist/localization/messages_de.js");
      }

      if (jQuery('html').attr('lang') === 'fr-FR') {
        __webpack_require__(/*! jquery-validation/dist/localization/messages_fr */ "./node_modules/jquery-validation/dist/localization/messages_fr.js");
      }

      if (jQuery('html').attr('lang') === 'es-ES') {
        __webpack_require__(/*! jquery-validation/dist/localization/messages_es */ "./node_modules/jquery-validation/dist/localization/messages_es.js");
      }

      if (jQuery('html').attr('lang') === 'it-IT') {
        __webpack_require__(/*! jquery-validation/dist/localization/messages_it */ "./node_modules/jquery-validation/dist/localization/messages_it.js");
      }

      if (jQuery('html').attr('lang') === 'nl-NL') {
        __webpack_require__(/*! jquery-validation/dist/localization/messages_nl */ "./node_modules/jquery-validation/dist/localization/messages_nl.js");
      }

      if (jQuery('html').attr('lang') === 'nl-be') {
        __webpack_require__(/*! jquery-validation/dist/localization/messages_nl */ "./node_modules/jquery-validation/dist/localization/messages_nl.js");
      }

      if (jQuery('html').attr('lang') === 'ru-RU') {
        __webpack_require__(/*! jquery-validation/dist/localization/messages_ru */ "./node_modules/jquery-validation/dist/localization/messages_ru.js");
      }
    }
  }]);

  return AuthForm;
}();

/***/ }),

/***/ "./src/js/helpers/HttpHelper.js":
/*!**************************************!*\
  !*** ./src/js/helpers/HttpHelper.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "HttpHelper": () => (/* binding */ HttpHelper)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

/**
 * Some helper functions for api calls with fetch
 */
var HttpHelper = /*#__PURE__*/function () {
  function HttpHelper() {
    _classCallCheck(this, HttpHelper);
  }

  _createClass(HttpHelper, null, [{
    key: "sendData",
    value: function () {
      var _sendData = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(url, method, data) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return jQuery.ajax(url, {
                  method: method,
                  data: data,
                  cache: false
                });

              case 2:
                return _context.abrupt("return", _context.sent);

              case 5:
                return _context.abrupt("return", _context.sent);

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }));

      function sendData(_x, _x2, _x3) {
        return _sendData.apply(this, arguments);
      }

      return sendData;
    }()
    /**
     *
     * @param {string} url
     * @param {object} data
     * @returns
     */

  }, {
    key: "get",
    value: function () {
      var _get = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(url, data) {
        var formData, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                formData = new URLSearchParams(data);
                _context2.next = 3;
                return this.sendData(url, 'get', data);

              case 3:
                response = _context2.sent;
                return _context2.abrupt("return", response);

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function get(_x4, _x5) {
        return _get.apply(this, arguments);
      }

      return get;
    }()
    /**
     *
     * @param {string} url
     * @param {object} data
     * @returns
     */

  }, {
    key: "post",
    value: function () {
      var _post = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3(url, data) {
        var formData, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                formData = new URLSearchParams(data);
                _context3.next = 3;
                return this.sendData(url, 'post', data);

              case 3:
                response = _context3.sent;
                return _context3.abrupt("return", response);

              case 5:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));

      function post(_x6, _x7) {
        return _post.apply(this, arguments);
      }

      return post;
    }()
  }]);

  return HttpHelper;
}();

/***/ }),

/***/ "./src/js/helpers/helpers.js":
/*!***********************************!*\
  !*** ./src/js/helpers/helpers.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Helpers)
/* harmony export */ });
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var Helpers = /*#__PURE__*/function () {
  function Helpers() {
    _classCallCheck(this, Helpers);

    this.apiBaseUrl = "".concat(pluginNameConfig.apiUrl, "/api-endpoint/v1");
    this.paginationWrapperId = 'product-pagination';
    this.paginationWrapperClass = 'product-pagination';
    this.paginationItemActiveClass = 'active';
    this.loaderId = 'my-loader';
  }
  /**
   *
   * @param {string} param
   * @returns
   */


  _createClass(Helpers, [{
    key: "getLocationParams",
    value: function getLocationParams(param) {
      var currentUrl = new URL(window.location.href);
      return currentUrl.searchParams.get(param);
    }
    /**
     *
     * @param {object} params (key: value)
     */

  }, {
    key: "changeLocationParams",
    value: function changeLocationParams() {
      var params = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var currentUrl = new URL(window.location.href);
      Object.entries(params).forEach(function (entry) {
        var _entry = _slicedToArray(entry, 2),
            key = _entry[0],
            value = _entry[1];

        currentUrl.searchParams.set(key, value);

        if (key === '') {
          currentUrl.searchParams["delete"](key);
        }
      });
      window.history.replaceState(null, null, currentUrl);
    }
  }, {
    key: "removeLocationParam",
    value: function removeLocationParam(param) {
      var currentUrl = new URL(window.location.href);
      currentUrl.searchParams["delete"](param);
      window.history.replaceState(null, null, currentUrl);
    }
  }, {
    key: "hideElement",
    value: function hideElement() {
      // this.paginationWrapper = jQuery(`#${this.paginationWrapperId}`)
      // this.paginationWrapper.fadeOut(250)
      this.loader.show();
    }
  }, {
    key: "showElement",
    value: function showElement() {
      // this.paginationWrapper = jQuery(`#${this.paginationWrapperId}`)
      // this.paginationWrapper.fadeIn(250)
      this.loader.hide();
    }
  }], [{
    key: "getViewportWidth",
    value: function getViewportWidth() {
      var viewportwidth;

      if (typeof window.innerWidth != 'undefined') {
        viewportwidth = window.innerWidth;
      } else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) {
        viewportwidth = document.documentElement.clientWidth;
      } else {
        viewportwidth = document.getElementsByTagName('body')[0].clientWidth;
      }

      return viewportwidth;
    }
  }, {
    key: "getViewportHeight",
    value: function getViewportHeight() {
      var viewportHeight;

      if (typeof window.innerHeight != 'undefined') {
        viewportHeight = window.innerHeight;
      } else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientHeight != 'undefined' && document.documentElement.clientHeight != 0) {
        viewportHeight = document.documentElement.clientHeight;
      } else {
        viewportHeight = document.getElementsByTagName('body')[0].clientHeight;
      }

      return viewportHeight;
    }
  }]);

  return Helpers;
}();



/***/ }),

/***/ "./src/sass/app.scss":
/*!***************************!*\
  !*** ./src/sass/app.scss ***!
  \***************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["assets/css/plugin-name","/assets/js/vendor"], () => (__webpack_exec__("./src/js/app.ts"), __webpack_exec__("./src/sass/app.scss")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=plugin-name.js.map
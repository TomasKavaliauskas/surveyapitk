/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/global.js":
/***/ (function(module, exports) {

$ = jQuery;

var k = -50;

$(document).ready(function () {

	$('#add-question').on('click', function (e) {
		e.preventDefault();

		if (k == -50) {

			if (!$('#create-button').length) {
				$('#buttons').append('<button class="btn btn-primary" id="create-button" type="submit">Kurti apklausą</button>');
			}
		}
		$('#questions-block').append('<div id="question_' + k + '" style="margin-bottom: 50px"><div class="form-group"><input placeholder="Klausimas" type="text" class="form-control" name="question_' + k + '_title" value=""/></div><div class="form-group"><input placeholder="Pasirinkimas 1" class="form-control" type="text" name="question_' + k + '_option_1" value=""/></div><div class="form-group"><input placeholder="Pasirinkimas 2" class="form-control" type="text" name="question_' + k + '_option_2" value=""/></div><div class="form-group"><input placeholder="Pasirinkimas 3" class="form-control" type="text" name="question_' + k + '_option_3" value=""/></div><div class="form-group"><input placeholder="Pasirinkimas 4" class="form-control" type="text" name="question_' + k + '_option_4" value=""/></div><button class="btn btn-primary delete-question" data-question="' + k + '">Ištrinti klausimą</button></div>');
		k++;
		bindDelete();
	});

	$('#hamburger').click(function (e) {

		$(this).toggleClass('active');

		if ($(this).hasClass('active')) {
			$('#menu').slideDown(500);
		} else {
			$('#menu').slideUp(500);
		}
	});
});

function bindDelete() {

	$('.delete-question').on('click', function (e) {

		e.preventDefault();
		if ($('#question_' + $(this).attr('data-question')).remove()) {
			k--;
			if (isEmpty($('#questions-block'))) {
				$("#create-button").remove();
			}
		}
	});
}

function isEmpty(el) {
	return !$.trim(el.html());
}

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/global.js");


/***/ })

/******/ });
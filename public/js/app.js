/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

// Log in to interacti with posts
function loginAlert() {
  $('#signup-modal').modal('show');
}
$(document).ready(function () {
  // Post Modal Get Data
  $('#noteModal').on('show.bs.modal', function (e) {
    var post = $(e.relatedTarget).data('post');
    post = JSON.parse(JSON.stringify(post));
    var community = $(e.relatedTarget).data('community');
    community = JSON.parse(JSON.stringify(community));
    var color = $(".sticky-note").css("background-color");
    $('#enlarged-data').html("<div class=\"modal-content\" style=\"width: 100%; height: 400px; padding: 15px; border-radius: 5px; background-color:" + color + "\">\n                    <div class=\"modal-header border-0\">\n                        <h1 class=\"modal-title fs-5\" id=\"noteModalLabel\">" + post['title'] + "</h1>\n                        <button tabindex=\"-1\" type=\"button\" class=\"btn material-symbols-outlined\" data-bs-dismiss=\"modal\">close_fullscreen</button>\n                    </div>\n                    <div class=\"modal-body\">\n                        <div class=\"container\" style=\"padding-left: 15px;\">\n                            <div id=\"descrip\">" + post['description'] + "</div>\n                            <p style=\"font-size: 12px;\">" + community['community_name'] + " \u2022 " + post['author'] + " \u2022 " + post['created_at'] + "</p>\n                            <div class=\"interactions\">\n                                <button tabindex=\"-1\" class=\"bi bi-hand-thumbs-up interaction-btn\">\n                                    <span class=\"like-count\">" + post['likes'] + "</span>\n                                </button>\n                                <button tabindex=\"-1\" class=\"bi bi-hand-thumbs-down interaction-btn\">\n                                        <span class=\"dislike-count\">" + post['dislikes'] + "</span>\n                                </button>\n                                <button tabindex=\"-1\" class=\"bi bi-chat-left-text interaction-btn\">\n                                    <span class=\"comment-count\">" + post['comments'] + "</span>\n                                </button>\n                            </div>\n                        </div>\n                    </div>\t\t\n                </div>");
  });

  // Like System
  $(".like, .unlike").click(function () {
    var id = this.id;
    var split_id = id.split("_");
    var text = split_id[0];
    var postid = split_id[1];
    var type = 0;
    var selected = 0;
    if (text == "like") {
      type = 1;
      // check if already selected
      if (this.matches('.selected')) {
        selected = 1;
      }
    } else {
      type = 0;
      // check if already selected
      if (this.matches('.selected')) {
        selected = 1;
      }
    }
    $.ajax({
      url: 'scripts/likeunlike.php',
      type: 'post',
      data: {
        postid: postid,
        type: type,
        selected: selected
      },
      dataType: 'json',
      success: function success(data) {
        var likes = data['likes'];
        var unlikes = data['unlikes'];
        $(".likes_" + postid).each(function () {
          $(this).text(likes);
        });
        $(".unlikes_" + postid).each(function () {
          $(this).text(unlikes);
        });
        if (type == 1) {
          if (selected == 1) {
            $(".like_" + postid).each(function () {
              $(this).removeClass('bi-hand-thumbs-up-fill selected').addClass('bi-hand-thumbs-up');
            });
          } else {
            $(".like_" + postid).each(function () {
              $(this).removeClass('bi-hand-thumbs-up').addClass('bi-hand-thumbs-up-fill selected');
            });
            $(".unlike_" + postid).each(function () {
              $(this).removeClass('bi-hand-thumbs-down-fill selected').addClass('bi-hand-thumbs-down');
            });
          }
        }
        if (type == 0) {
          if (selected == 1) {
            $(".unlike_" + postid).each(function () {
              $(this).removeClass('bi-hand-downs-fill selected').addClass('bi-hand-thumbs-down');
            });
          } else {
            $(".unlike_" + postid).each(function () {
              $(this).removeClass('bi-hand-thumbs-down').addClass('bi-hand-thumbs-down-fill selected');
            });
            $(".like_" + postid).each(function () {
              $(this).removeClass('bi-hand-thumbs-up-fill selected').addClass('bi-hand-thumbs-up');
            });
          }
        }
      }
    });
  });

  // Popovers
  $("#guidelines-popover").popover({
    trigger: 'focus',
    html: true,
    placement: "bottom",
    title: 'studyspot Guidelines',
    content: function content() {
      return $("#guidelines-popover-content").html();
    }
  });

  // Comment Modal Get Data
  $('#commentModal').on('show.bs.modal', function (e) {
    var rowid = $(e.relatedTarget).data('id');
    $.ajax({
      type: 'post',
      url: 'scripts/fetch_comments.php',
      data: {
        rowid: rowid
      },
      success: function success(data) {
        $('.fetch-comments').html(data); // Show fetched data from database
      }
    });
  });

  // Signup --> Login modal
  $('#already_registered').click(function () {
    $('#signup-modal').modal('hide');
    $('#login-modal').modal('show');
  });

  // Initialize Tooltip
  $('[data-toggle="tooltip"]').tooltip({
    container: 'body',
    trigger: 'hover',
    placement: "right"
  });
});

/***/ }),

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/css/app.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
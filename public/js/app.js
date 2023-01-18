/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

$(document).ready(function () {
  // Like System
  $(".like, .dislike").click(function () {
    var post = $(this).data("post");
    // remove all &quot; from post
    post = post.replace(/&quot;/g, '"');
    // convert string to object
    post = JSON.parse(post);
    if ($(this).hasClass("like")) {
      var url = "/" + post["id"] + "/like";
    } else {
      var url = "/" + post["id"] + "/dislike";
    }
    $.ajaxSetup({
      headers: {
        csrftoken: "{{ csrf_token() }}"
      }
    });
    $.ajax({
      headers: {
        csrftoken: "{{ csrf_token() }}"
      },
      url: url,
      type: "GET",
      data: {
        post_id: post["id"]
      },
      dataType: "json",
      success: function success(response) {
        // Update like and dislike buttons
        if (response["like"] == "like added") {
          if (response["dislike"] == "dislike removed") {
            // find dislike button and remove class
            $("#dislikeBtn-" + response["post-id"] + "-small, #dislikeBtn-" + response["post-id"] + "-enlarge").removeClass("bi-hand-thumbs-down-fill").addClass("bi-hand-thumbs-down");
            // get the number of dislikes and subtract 1
            var dislikes = $("#dislikeBtn-" + response["post-id"] + "-small").find("span").text();
            dislikes = parseInt(dislikes) - 1;
            // update the number of dislikes
            $("#dislikeBtn-" + response["post-id"] + "-small, #dislikeBtn-" + response["post-id"] + "-enlarge").find("span").text(dislikes);
          }
          // find like button and add class
          $("#likeBtn-" + response["post-id"] + "-small, #likeBtn-" + response["post-id"] + "-enlarge").removeClass("bi-hand-thumbs-up").addClass("bi-hand-thumbs-up-fill");
          // get the number of likes and add 1
          var likes = $("#likeBtn-" + response["post-id"] + "-small").find("span").text();
          likes = parseInt(likes) + 1;
          // update the number of likes
          $("#likeBtn-" + response["post-id"] + "-small, #likeBtn-" + response["post-id"] + "-enlarge").find("span").text(likes);
        } else if (response["dislike"] == "dislike added") {
          if (response["like"] == "like removed") {
            // find like button and remove class
            $("#likeBtn-" + response["post-id"] + "-small, #likeBtn-" + response["post-id"] + "-enlarge").removeClass("bi-hand-thumbs-up-fill").addClass("bi-hand-thumbs-up");
            // get the number of likes and subtract 1
            var likes = $("#likeBtn-" + response["post-id"] + "-small").find("span").text();
            likes = parseInt(likes) - 1;
            // update the number of likes
            $("#likeBtn-" + response["post-id"] + "-small, #likeBtn-" + response["post-id"] + "-enlarge").find("span").text(likes);
          }
          // find dislike button and add class
          $("#dislikeBtn-" + response["post-id"] + "-small, #dislikeBtn-" + response["post-id"] + "-enlarge").removeClass("bi-hand-thumbs-down").addClass("bi-hand-thumbs-down-fill");
          // get the number of dislikes and add 1
          var dislikes = $("#dislikeBtn-" + response["post-id"] + "-small").find("span").text();
          dislikes = parseInt(dislikes) + 1;
          // update the number of dislikes
          $("#dislikeBtn-" + response["post-id"] + "-small, #dislikeBtn-" + response["post-id"] + "-enlarge").find("span").text(dislikes);
        } else if (response["dislike"] == "dislike removed") {
          // find dislike button and remove class
          $("#dislikeBtn-" + response["post-id"] + "-small, #dislikeBtn-" + response["post-id"] + "-enlarge").removeClass("bi-hand-thumbs-down-fill").addClass("bi-hand-thumbs-down");
          // get the number of dislikes and subtract 1
          var dislikes = $("#dislikeBtn-" + response["post-id"] + "-small").find("span").text();
          dislikes = parseInt(dislikes) - 1;
          // update the number of dislikes
          $("#dislikeBtn-" + response["post-id"] + "-small, #dislikeBtn-" + response["post-id"] + "-enlarge").find("span").text(dislikes);
        } else {
          // find like button and remove class
          $("#likeBtn-" + response["post-id"] + "-small, #likeBtn-" + response["post-id"] + "-enlarge").removeClass("bi-hand-thumbs-up-fill").addClass("bi-hand-thumbs-up");
          // get the number of likes and subtract 1
          var likes = $("#likeBtn-" + response["post-id"] + "-small").find("span").text();
          likes = parseInt(likes) - 1;
          // update the number of likes
          $("#likeBtn-" + response["post-id"] + "-small, #likeBtn-" + response["post-id"] + "-enlarge").find("span").text(likes);
        }
      }
    });
  });

  // Popovers
  $("#guidelines-popover").popover({
    trigger: "focus",
    html: true,
    placement: "bottom",
    title: "studyspot Guidelines",
    content: function content() {
      return $("#guidelines-popover-content").html();
    }
  });

  // Comment Modal Get Data
  $("#commentModal").on("show.bs.modal", function (e) {
    var rowid = $(e.relatedTarget).data("id");
    $.ajax({
      type: "post",
      url: "scripts/fetch_comments.php",
      data: {
        rowid: rowid
      },
      success: function success(data) {
        $(".fetch-comments").html(data); // Show fetched data from database
      }
    });
  });

  // Signup --> Login modal
  $("#already_registered").click(function () {
    $("#signup-modal").modal("hide");
    $("#login-modal").modal("show");
  });

  // Login --> Signup modal
  $("#no_account").click(function () {
    $("#login-modal").modal("hide");
    $("#signup-modal").modal("show");
  });

  // Opens modal if errors are present
  if ($("#signup-modal").find(".text-danger").length) {
    $("#signup-modal").modal("show");
  } else if ($("#login-modal").find(".text-danger").length) {
    $("#login-modal").modal("show");
  }

  // Initialize Tooltip
  $('[data-toggle="tooltip"]').tooltip({
    container: "body",
    trigger: "hover",
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
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

function timeSince(post_date) {
  // post date to seconds
  var date = new Date(post_date).getTime();

  // get current time in seconds
  var now = new Date().getTime();
  var seconds = Math.floor((now - date) / 1000);
  var interval = seconds / 31536000;
  if (interval > 1) {
    return Math.floor(interval) + " years";
  }
  interval = seconds / 2592000;
  if (interval > 1) {
    return Math.floor(interval) + " months";
  }
  interval = seconds / 86400;
  if (interval < 2 && interval > 1) {
    return Math.floor(interval) + " day";
  } else if (interval > 1) {
    return Math.floor(interval) + " days";
  }
  interval = seconds / 3600;
  if (interval < 2 && interval > 1) {
    return Math.floor(interval) + " hour";
  } else if (interval > 1) {
    return Math.floor(interval) + " hours";
  }
  interval = seconds / 60;
  if (interval > 1) {
    return Math.floor(interval) + " minutes";
  }
  return Math.floor(seconds) + " seconds";
}
function submitCommentForm(event) {
  // Prevent form from submitting normally.
  event.preventDefault();
  var comment = $("#commentBody").val();
  var post_id = $("#post_id").val();
  var user_id = $("#user_id").val();

  // get action from form
  var url = $("#create-cmt-" + post_id).attr("action");
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
  });
  $.ajax({
    headers: {
      csrftoken: "{{ csrf_token() }}"
    },
    type: "POST",
    dataType: "json",
    url: url,
    data: {
      description: comment,
      post_id: post_id,
      user_id: user_id
    },
    success: function success(response) {
      // clear comment box
      $("#commentBody").val("");

      // add animation to comment button
      $("#create-cmt-btn").addClass("animate__animated animate__heartBeat");
      $("#create-cmt-btn").css("background-color", "#ffcb05", "color", "#00274c");

      // disable comment btn for 2 seconds
      $("#create-cmt-btn").prop("disabled", true);
      setTimeout(function () {
        $("#create-cmt-btn").css("background-color", "#00274c", "color", "#ffcb05");
        $("#create-cmt-btn").prop("disabled", false);
        $("#create-cmt-btn").removeClass("animate__animated animate__wobble animate__heartBeat animate__animated");
      }, 2000);

      // get username from response
      var comment = response["comment"];
      var post_id = comment["post_id"];

      // get comment count find span
      var comment_count = $("#commentBtn-" + post_id + "-small").find("span").text();
      var new_comment_count = parseInt(comment_count) + 1;
      var comment_count = $("#commentBtn-" + post_id + "-small").find("span").text(new_comment_count);
      $("#commentBtn-" + post_id + "-small").click();
    },
    error: function error(response) {
      // check if message is already displayed
      if ($("#error-message").length == 0) {
        // add message in form
        $("#create-cmt-" + post_id).after('<span class="text-danger m-3 mt-0 mb-0" id="error-message">Please add a comment! 💬</span>');
        // add animation to comment button
        $("#create-cmt-btn").addClass("animate__animated animate__wobble");

        // remove bottom padding from form
        $("#create-cmt-" + post_id).css("padding-bottom", "0");
        // remove message after 2 seconds
        setTimeout(function () {
          $("#error-message").remove();
          $("#create-cmt-" + post_id).css("padding-bottom", "10px");
          // remove animation from comment button
          $("#create-cmt-btn").removeClass("animate__animated animate__wobble animate__heartBeat animate__animated");
        }, 2000);
      }
    }
  });
}
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

  // Get Comments
  $(".commentBtn").on("click", function (e) {
    e.preventDefault();
    var post_id = $(this).data("postid");
    var url = $(this).data("url");
    var log = $(this).data("log");
    // change form id
    $(".create-comment-form").attr("id", "create-cmt-" + post_id);
    if (log == "out") {
      // hide comment form
      $(".create-comment-form").hide();
    } else {
      // show comment form
      $(".create-comment-form").show();

      // Set action for form
      $("#create-cmt-" + post_id).attr("action", "/" + post_id + "/comment");
      $("#post_id").val(post_id);
    }
    $.ajax({
      url: url,
      type: "GET",
      dataType: "json",
      data: {
        post_id: post_id
      },
      success: function success(response) {
        comments = response["comments"];
        var commentSize = Object.keys(comments).length;
        $("#num_of_comments").text(commentSize);
        var data = "";

        // start from end of array
        for (var i = commentSize - 1; i >= 0; i--) {
          comment = comments[i];
          // Get size of comments
          var username = comment["username"];
          var description = comment["description"];
          var post_date = comment["created_at"];

          // Post date to seconds
          post_date = timeSince(post_date);
          var borderStyle = "border-radius: 0;";

          // Check if this is the last comment in the array
          if (comment == comments[0]) {
            var borderStyle = "border-radius: 0 0 5px 5px;";
          }
          data += "<li class=\"list-group-item\" style=\"" + borderStyle + "list-style-type: none;\" id=\"comment-item\">\n                        <div class=\"container\" style=\"display: flex; padding: 10px; align-items: center;\">\n                            <p style=\"margin: 0; font-weight: bold; font-size: 17px; margin-right: 10px;\">" + username + "</p>\n                            <p style=\"margin: 0; font-size: 17px;\">" + description + "</p>\n                        </div>\n                        <div class=\"container\" style=\"display: flex; padding: 10px; align-items: center;\">\n                            <p style=\"font-size: 12px; color: rgb(171, 171, 171);\">" + post_date + "</p>\n                        </div>\n                        </li>";
        }
        // if there are no comments
        if (commentSize == 0) {
          var data = "\n                        <li class=\"list-group-item\" style=\"border-radius:0;\" id=\"comment-item\">                 \n                        <div class=\"container\" style=\"display: flex; padding: 10px; align-items: center;\">\n                            <p>There are no comments</p>\n                        </div>  \n                        </li>";
        }

        // append list item to comment list and show modal
        $("#all-comments").html(data);
      }
    });
  });

  // Post Comment
  $("#create-cmt-btn").on("click", submitCommentForm.bind(this));

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
  if ($("#cmtyModal").find(".text-danger").length) {
    $("#cmtyModal").modal("show");
  } else if ($("#signup-modal").find(".text-danger").length) {
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

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
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
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
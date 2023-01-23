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
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        headers: {
            csrftoken: "{{ csrf_token() }}",
        },
        type: "POST",
        dataType: "json",
        url: url,
        data: {
            description: comment,
            post_id: post_id,
            user_id: user_id,
        },
        success: function (response) {
            // clear comment box
            $("#commentBody").val("");

            // add animation to comment button
            $("#create-cmt-btn").addClass(
                "animate__animated animate__heartBeat"
            );

            $("#create-cmt-btn").css(
                "background-color",
                "#ffcb05",
                "color",
                "#00274c"
            );

            // disable comment btn for 2 seconds
            $("#create-cmt-btn").prop("disabled", true);
            setTimeout(function () {
                $("#create-cmt-btn").css(
                    "background-color",
                    "#00274c",
                    "color",
                    "#ffcb05"
                );
                $("#create-cmt-btn").prop("disabled", false);
                $("#create-cmt-btn").removeClass(
                    "animate__animated animate__wobble animate__heartBeat animate__animated"
                );
            }, 2000);

            // get username from response
            var comment = response["comment"];
            var post_id = comment["post_id"];

            // get comment count find span
            var comment_count = $("#commentBtn-" + post_id + "-small")
                .find("span")
                .text();
            var new_comment_count = parseInt(comment_count) + 1;
            var comment_count = $("#commentBtn-" + post_id + "-small")
                .find("span")
                .text(new_comment_count);
            $("#commentBtn-" + post_id + "-small").click();
        },
        error: function (response) {
            // check if message is already displayed
            if ($("#error-message").length == 0) {
                // add message in form
                $("#create-cmt-" + post_id).after(
                    '<span class="text-danger m-3 mt-0 mb-0" id="error-message">Please add a comment! 💬</span>'
                );
                // add animation to comment button
                $("#create-cmt-btn").addClass(
                    "animate__animated animate__wobble"
                );

                // remove bottom padding from form
                $("#create-cmt-" + post_id).css("padding-bottom", "0");
                // remove message after 2 seconds
                setTimeout(function () {
                    $("#error-message").remove();
                    $("#create-cmt-" + post_id).css("padding-bottom", "10px");
                    // remove animation from comment button
                    $("#create-cmt-btn").removeClass(
                        "animate__animated animate__wobble animate__heartBeat animate__animated"
                    );
                }, 2000);
            }
        },
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

        $.ajaxSetup({ headers: { csrftoken: "{{ csrf_token() }}" } });

        $.ajax({
            headers: {
                csrftoken: "{{ csrf_token() }}",
            },
            url: url,
            type: "GET",
            data: {
                post_id: post["id"],
            },
            dataType: "json",
            success: function (response) {
                // Update like and dislike buttons
                if (response["like"] == "like added") {
                    if (response["dislike"] == "dislike removed") {
                        // find dislike button and remove class
                        $(
                            "#dislikeBtn-" +
                                response["post-id"] +
                                "-small, #dislikeBtn-" +
                                response["post-id"] +
                                "-enlarge"
                        )
                            .removeClass("bi-hand-thumbs-down-fill")
                            .addClass("bi-hand-thumbs-down");
                        // get the number of dislikes and subtract 1
                        var dislikes = $(
                            "#dislikeBtn-" + response["post-id"] + "-small"
                        )
                            .find("span")
                            .text();
                        dislikes = parseInt(dislikes) - 1;
                        // update the number of dislikes
                        $(
                            "#dislikeBtn-" +
                                response["post-id"] +
                                "-small, #dislikeBtn-" +
                                response["post-id"] +
                                "-enlarge"
                        )
                            .find("span")
                            .text(dislikes);
                    }
                    // find like button and add class
                    $(
                        "#likeBtn-" +
                            response["post-id"] +
                            "-small, #likeBtn-" +
                            response["post-id"] +
                            "-enlarge"
                    )
                        .removeClass("bi-hand-thumbs-up")
                        .addClass("bi-hand-thumbs-up-fill");
                    // get the number of likes and add 1
                    var likes = $("#likeBtn-" + response["post-id"] + "-small")
                        .find("span")
                        .text();
                    likes = parseInt(likes) + 1;
                    // update the number of likes
                    $(
                        "#likeBtn-" +
                            response["post-id"] +
                            "-small, #likeBtn-" +
                            response["post-id"] +
                            "-enlarge"
                    )
                        .find("span")
                        .text(likes);
                } else if (response["dislike"] == "dislike added") {
                    if (response["like"] == "like removed") {
                        // find like button and remove class
                        $(
                            "#likeBtn-" +
                                response["post-id"] +
                                "-small, #likeBtn-" +
                                response["post-id"] +
                                "-enlarge"
                        )
                            .removeClass("bi-hand-thumbs-up-fill")
                            .addClass("bi-hand-thumbs-up");
                        // get the number of likes and subtract 1
                        var likes = $(
                            "#likeBtn-" + response["post-id"] + "-small"
                        )
                            .find("span")
                            .text();
                        likes = parseInt(likes) - 1;
                        // update the number of likes
                        $(
                            "#likeBtn-" +
                                response["post-id"] +
                                "-small, #likeBtn-" +
                                response["post-id"] +
                                "-enlarge"
                        )
                            .find("span")
                            .text(likes);
                    }
                    // find dislike button and add class
                    $(
                        "#dislikeBtn-" +
                            response["post-id"] +
                            "-small, #dislikeBtn-" +
                            response["post-id"] +
                            "-enlarge"
                    )
                        .removeClass("bi-hand-thumbs-down")
                        .addClass("bi-hand-thumbs-down-fill");
                    // get the number of dislikes and add 1
                    var dislikes = $(
                        "#dislikeBtn-" + response["post-id"] + "-small"
                    )
                        .find("span")
                        .text();
                    dislikes = parseInt(dislikes) + 1;
                    // update the number of dislikes
                    $(
                        "#dislikeBtn-" +
                            response["post-id"] +
                            "-small, #dislikeBtn-" +
                            response["post-id"] +
                            "-enlarge"
                    )
                        .find("span")
                        .text(dislikes);
                } else if (response["dislike"] == "dislike removed") {
                    // find dislike button and remove class
                    $(
                        "#dislikeBtn-" +
                            response["post-id"] +
                            "-small, #dislikeBtn-" +
                            response["post-id"] +
                            "-enlarge"
                    )
                        .removeClass("bi-hand-thumbs-down-fill")
                        .addClass("bi-hand-thumbs-down");
                    // get the number of dislikes and subtract 1
                    var dislikes = $(
                        "#dislikeBtn-" + response["post-id"] + "-small"
                    )
                        .find("span")
                        .text();
                    dislikes = parseInt(dislikes) - 1;
                    // update the number of dislikes
                    $(
                        "#dislikeBtn-" +
                            response["post-id"] +
                            "-small, #dislikeBtn-" +
                            response["post-id"] +
                            "-enlarge"
                    )
                        .find("span")
                        .text(dislikes);
                } else {
                    // find like button and remove class
                    $(
                        "#likeBtn-" +
                            response["post-id"] +
                            "-small, #likeBtn-" +
                            response["post-id"] +
                            "-enlarge"
                    )
                        .removeClass("bi-hand-thumbs-up-fill")
                        .addClass("bi-hand-thumbs-up");
                    // get the number of likes and subtract 1
                    var likes = $("#likeBtn-" + response["post-id"] + "-small")
                        .find("span")
                        .text();
                    likes = parseInt(likes) - 1;
                    // update the number of likes
                    $(
                        "#likeBtn-" +
                            response["post-id"] +
                            "-small, #likeBtn-" +
                            response["post-id"] +
                            "-enlarge"
                    )
                        .find("span")
                        .text(likes);
                }
            },
        });
    });

    // Popovers
    $("#guidelines-popover").popover({
        trigger: "focus",
        html: true,
        placement: "bottom",
        title: "studyspot Guidelines",
        content: function () {
            return $("#guidelines-popover-content").html();
        },
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
            $("#create-cmt-" + post_id).attr(
                "action",
                "/" + post_id + "/comment"
            );
            $("#post_id").val(post_id);
        }

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            data: {
                post_id: post_id,
            },
            success: function (response) {
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

                    data +=
                        `<li class="list-group-item" style="` +
                        borderStyle +
                        `list-style-type: none;" id="comment-item">
                        <div class="container" style="display: flex; padding: 10px; align-items: center;">
                            <p style="margin: 0; font-weight: bold; font-size: 17px; margin-right: 10px;">` +
                        username +
                        `</p>
                            <p style="margin: 0; font-size: 17px;">` +
                        description +
                        `</p>
                        </div>
                        <div class="container" style="display: flex; padding: 10px; align-items: center;">
                            <p style="font-size: 12px; color: rgb(171, 171, 171);">` +
                        post_date +
                        `</p>
                        </div>
                        </li>`;
                }
                // if there are no comments
                if (commentSize == 0) {
                    var data = `
                        <li class="list-group-item" style="border-radius:0;" id="comment-item">                 
                        <div class="container" style="display: flex; padding: 10px; align-items: center;">
                            <p>There are no comments</p>
                        </div>  
                        </li>`;
                }

                // append list item to comment list and show modal
                $("#all-comments").html(data);
            },
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
        placement: "right",
    });
});

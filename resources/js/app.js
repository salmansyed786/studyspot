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

    // Comment Modal Get Data
    $("#commentModal").on("show.bs.modal", function (e) {
        var rowid = $(e.relatedTarget).data("id");
        $.ajax({
            type: "post",
            url: "scripts/fetch_comments.php",
            data: {
                rowid: rowid,
            },
            success: function (data) {
                $(".fetch-comments").html(data); // Show fetched data from database
            },
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
        placement: "right",
    });
});

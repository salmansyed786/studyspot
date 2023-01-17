$(document).ready(function () {
    // Like System
    // $(".like, .unlike").click(function () {
    //     var id = this.id;
    //     var split_id = id.split("_");
    //     var text = split_id[0];
    //     var postid = split_id[1];
    //     var type = 0;
    //     var selected = 0;
    //     if (text == "like") {
    //         type = 1;
    //         // check if already selected
    //         if (this.matches(".selected")) {
    //             selected = 1;
    //         }
    //     } else {
    //         type = 0;
    //         // check if already selected
    //         if (this.matches(".selected")) {
    //             selected = 1;
    //         }
    //     }
    //     $.ajax({
    //         url: "../views/components/likeunlike.php",
    //         type: "post",
    //         data: {
    //             postid: postid,
    //             type: type,
    //             selected: selected,
    //         },
    //         dataType: "json",
    //         success: function (data) {
    //             var likes = data["likes"];
    //             var unlikes = data["unlikes"];

    //             $(".likes_" + postid).each(function () {
    //                 $(this).text(likes);
    //             });

    //             $(".unlikes_" + postid).each(function () {
    //                 $(this).text(unlikes);
    //             });

    //             if (type == 1) {
    //                 if (selected == 1) {
    //                     $(".like_" + postid).each(function () {
    //                         $(this)
    //                             .removeClass("bi-hand-thumbs-up-fill selected")
    //                             .addClass("bi-hand-thumbs-up");
    //                     });
    //                 } else {
    //                     $(".like_" + postid).each(function () {
    //                         $(this)
    //                             .removeClass("bi-hand-thumbs-up")
    //                             .addClass("bi-hand-thumbs-up-fill selected");
    //                     });

    //                     $(".unlike_" + postid).each(function () {
    //                         $(this)
    //                             .removeClass(
    //                                 "bi-hand-thumbs-down-fill selected"
    //                             )
    //                             .addClass("bi-hand-thumbs-down");
    //                     });
    //                 }
    //             }
    //             if (type == 0) {
    //                 if (selected == 1) {
    //                     $(".unlike_" + postid).each(function () {
    //                         $(this)
    //                             .removeClass("bi-hand-downs-fill selected")
    //                             .addClass("bi-hand-thumbs-down");
    //                     });
    //                 } else {
    //                     $(".unlike_" + postid).each(function () {
    //                         $(this)
    //                             .removeClass("bi-hand-thumbs-down")
    //                             .addClass("bi-hand-thumbs-down-fill selected");
    //                     });

    //                     $(".like_" + postid).each(function () {
    //                         $(this)
    //                             .removeClass("bi-hand-thumbs-up-fill selected")
    //                             .addClass("bi-hand-thumbs-up");
    //                     });
    //                 }
    //             }
    //         },
    //     });
    // });

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

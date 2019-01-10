$(document).ready(function() {

    $('.like').on('click', function(event) {
        var imageId = event.currentTarget.id;

        $.ajax({
            method: 'POST',
            url: urlLike,
            data: {
                imageId: imageId,
                _token: token
            }
        }).done(function(response) {
            var likesCount = response.numberOfLikes;
            if ($('.like').hasClass('liked')) {
                $('.like').removeClass('liked');
                $('.like').html('<i class="far fa-thumbs-up fa-fw"></i> Like');
            } else {
                $('.like').addClass('liked');
                $('.like').html('<i class="fas fa-check fa-fw"></i> Liked');
            }
            $('.likes-count').html('<i class="far fa-thumbs-up fa-fw"></i>' + likesCount + " Likes")
        });
    });

    $('.post-comment').on('click', function(event) {
        event.preventDefault();
        var userId = $("input[name=user_id]").val();
        var imageId = $("input[name=image_id]").val();
        var comment = $("textarea[name=comment]").val();

        $.ajax({
            method: 'POST',
            url: urlComment,
            data: {
                userId: userId,
                imageId: imageId,
                comment: comment,
                _token: token
            }
        }).done(function(response) {
            var commentsCount = response.image.comments;
            var comment = response.comment.comment;

            var appendHtml = '<div class="comment-flexbox">' +
                '<div class="comment-container">' +
                '<a href="../profile/' + response.image.user.username + '">' +
                '<img class="comment-picture" src="../storage/uploads/profile_pictures/edited/' + response.image.user.image_file_name + '">' +
                '</a>' +
                '</div>' +
                '<div class="comment-info-container">' +
                '<a href="../profile/' + response.image.user.username + '">' + response.image.user.username + '</a>' +
                '<p>' + comment + '</p>' +
                '</div>' +
                '<div class="comment-actions-container">' +
                '<i class="fas fa-times delete-comment" data-id="' + response.comment.id + '"></i>' +
                '</div>' +
                '</div>';

            $("textarea[name=comment]").val("");

            if ($('.comments-container').length) {
                $('.comments-container').prepend(appendHtml);
            } else {
                var x = document.createElement("div");
                var artworkInfoContainer = $('.artwork-info-container');
                artworkInfoContainer.append(x);
                x.className = "comments-container";
                $('.comments-container').prepend(appendHtml);
            }

            $('.comments-count').html("<i class='far fa-comments fa-fw'></i>" + commentsCount + " Comments")
        })
    });

    $(document).on('click', '.delete-comment', function(event) {
        var commentId = $(this).data('id');
        var imageId = $(this).data('image');
        var flexbox = $(this).parents().eq(1);
        $.ajax({
            method: 'POST',
            url: urlDeleteComment,
            data: {
                commentId: commentId,
                imageId: imageId,
                _method: 'delete',
                _token: token
            }
        }).done(function(response) {
            var commentsCount = response.commentsCount;
            $('.comments-count').html("<i class='far fa-comments fa-fw'></i>" + commentsCount + " Comments")
            flexbox.remove();
        })
    });

    $('.dropdown').on('click', function() {
        $('.navigation-ul li:not(:first-child)').toggleClass('active');
    });

    function fitImage() {
        var navHeight = $("nav.navigation").outerHeight();
        var viewport = $(window).height();
        $(".specific-image").first().css({
            "max-height": viewport - navHeight
        });
        $(".specific-image").show();
        $(".artwork-flexbox").css({
            "min-height": viewport - navHeight + 50
        });
    }

    fitImage();

    $(window).on("resize", fitImage);

    function displayUpdatedProfileImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.new-avatar-picture').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function displayInputImage(input) {
        $(".new-avatar-picture").remove();
        var files = input.files;

        for (var i = 0; i < files.length; i++) {
            var x = document.createElement("img");
            (function(imgElement) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = function(e) {
                    imgElement.setAttribute("src", e.target.result);
                }
                reader.readAsDataURL(file);

                imgElement.className = "new-avatar-picture";
                $('.upload-btn-wrapper').prepend(imgElement);
            }(x));
        }
    }

    $(".new-avatar").change(function() {
        displayUpdatedProfileImage(this);
    });

    $(".upload-input").change(function() {
        displayInputImage(this);
    });

});

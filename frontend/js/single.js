// This script loads a single post by ID from the URL and injects its data into the placeholders in single.html
$(document).ready(function() {
    // Helper to get query param from hash or search
    function getPostIdFromUrl() {
        // Handles #single?id=1, #single&foo=bar&id=1, etc.
        var hash = window.location.hash;
        var queryIndex = hash.indexOf('?');
        if (queryIndex === -1) return null;
        var query = hash.substring(queryIndex + 1);
        var params = new URLSearchParams(query);
        return params.get('id');
    }

    var postId = getPostIdFromUrl();
    if (!postId) {
        $("#single-post-content").html('<p class="text-danger">No post ID provided.</p>');
        return;
    }

    PostService.getPostById(postId, function(post) {
        if (!post) {
            $("#single-post-content").html('<p class="text-danger">Post not found.</p>');
            return;
        }
        // Inject post title into the main h1 header
        $(".post-entry.text-center h1").text(post.title);
        // Inject post content into the content body
        $("#single-post-content").html(`<p>${post.content}</p>`);
    });

    // Load comments for this post
    CommentService.getCommentsByPostId(postId, function(comments) {
        CommentService.renderComments(comments);
    });
});

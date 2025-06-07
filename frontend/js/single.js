// This script loads a single post by ID from the URL and injects its data into the placeholders in single.html
$(document).ready(function() {
    // Helper to get query param from hash or search
    function getPostIdFromUrl() {
        // Try to get id from both hash (SPApp) and search (direct load)
        var hash = window.location.hash;
        var queryIndex = hash.indexOf('?');
        if (queryIndex !== -1) {
            var query = hash.substring(queryIndex + 1);
            var params = new URLSearchParams(query);
            if (params.get('id')) return params.get('id');
        }
        // Fallback: try to extract from search (direct load)
        var search = window.location.search;
        if (search) {
            var params2 = new URLSearchParams(search.substring(1));
            if (params2.get('id')) return params2.get('id');
        }
        return null;
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
});

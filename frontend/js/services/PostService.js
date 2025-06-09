var PostService = {
    getPosts: function() {
        RestClient.get(
            "posts",
            function(response) {
                if (response) {
                    PostService.renderPosts(response.data);
                }
            },
            function(jqXHR) {
                toastr.error(jqXHR.responseJSON.message);
            }
        );
    },

    renderPosts:  function(posts) {
        console.log("Idu postovi");
        console.log("Received posts data:", posts); // Log the received posts data for inspection

        // Ensure posts is an array
        if (!Array.isArray(posts)) {
            console.error("Error: 'posts' data is not an array. Received:", posts);
            posts = []; // Default to an empty array to prevent further errors
        }

        allPosts = "";
        posts.forEach(post => {
            // Ensure post.content is a string before calling substring/length
            const contentString = (typeof post.content === 'string') ? post.content : "";
            const truncatedContent = contentString.substring(0, 100) + (contentString.length > 100 ? "..." : "");

            let postDate = 'Date not available';
            // Use post.published_at for the date
            if (post.published_at) {
                const dateObj = new Date(post.published_at);
                if (!isNaN(dateObj.getTime())) {
                    postDate = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                } else {
                    console.warn(`Invalid date format for post ID ${post.id}: ${post.published_at}`);
                    // Keep 'Date not available'
                }
            }

            const title = post.title || "Untitled Post"; // Default title
            const id = post.id || "#"; // Default ID for links

            eachPost = `<div class="col-md-6 col-lg-3">
					<div class="blog-entry">
						<a href="html/single.html#?id=${id}" class="img-link">\t\t\t\t\t\t</a>
						<span class="date">${postDate}</span>
						<h2><a href="html/single.html#?id=${id}">${title}</a></h2>
						<p>${truncatedContent}</p>
					</div>
				</div>`;
            allPosts += eachPost;
        });

        $("#blog-posts").html(allPosts);

        if (allPosts === "" && posts.length > 0) {
            console.warn("Warning: Posts data was present, but no HTML was generated. Check for issues within the loop or if essential post data (like id, title) was missing for all posts.");
        } else if (allPosts === "") {
            console.log("No posts were rendered. #blog-posts is now empty. This could be due to an empty posts array or data issues.");
            // Optionally, display a message to the user:
            // $("#blog-posts").html("<p>No posts available at the moment.</p>");
        }
    },

    getPostById: function(postId, callback) {
        RestClient.get(
            "posts/" + postId,
            function(response) {
                // The backend returns the post directly, not wrapped in a 'data' property
                if (response && response.id) {
                    callback(response);
                } else {
                    callback(null);
                }
            },
            function(jqXHR) {
                toastr.error(jqXHR.responseJSON?.message || "Error loading post.");
                callback(null);
            }
        );
    }

}
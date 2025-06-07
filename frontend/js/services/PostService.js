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
        console.log("Idu postovi")
        console.log(posts)
        allPosts = ""
        posts.forEach(post => {
            eachPost = `<div class="col-md-6 col-lg-3">
					<div class="blog-entry">
						<a href="html/single.html#?id=${post.id}" class="img-link">						</a>
						<span class="date">Apr. 14th, 2022</span>
						<h2><a href="html/single.html#?id=${post.id}">${post.title}</a></h2>
						<p>${post.content}</p>
					</div>
				</div>`
            allPosts += eachPost;
        });
        $("#blog-posts").html(allPosts);
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
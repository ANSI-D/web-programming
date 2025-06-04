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
						<a href="single.html" class="img-link">
							<img src="images/img_1_horizontal.jpg" alt="Image" class="img-fluid">
						</a>
						<span class="date">Apr. 14th, 2022</span>
						<h2><a href="single.html">${post.title}</a></h2>
						<p>${post.content}</p>
						<p><a href="#" class="read-more">Continue Reading</a></p>
					</div>
				</div>`
            allPosts += eachPost;
        });
        $("#blog-posts").html(allPosts);
    }

}
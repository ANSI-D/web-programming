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
            eachPost = `<div class="post-content-body">
            <p>Many businesses and individuals rely on cloud services for storage, collaboration, and scalability. While cloud providers invest heavily in security, breaches still happen—often due to misconfigurations, weak access controls, or third-party vulnerabilities.</p>

            <h3>Why You Shouldn't Take Cloud Security for Granted</h3>
            <p>${post.content}</p>
            <p><strong>2. Misconfigurations Are Common</strong> – Publicly exposed storage buckets, unencrypted databases, and overly permissive permissions can lead to leaks.</p>
            <p><strong>3. Insider & Third-Party Risks</strong> – Employees or vendors with excessive access can accidentally (or intentionally) compromise data.</p>
            <p><strong>4. Compliance Risks</strong> – Even if your provider is compliant (e.g., GDPR, HIPAA), your setup must meet those standards too.</p>


            <h3>How to Improve Cloud Data Security</h3>
            <ul>
              <li><strong>Enable Multi-Factor Authentication (MFA)</strong> – Prevent unauthorized access.</li>
              <li><strong>Encrypt Sensitive Data</strong> – Both at rest and in transit.</li>
              <li><strong>Audit Permissions Regularly</strong> – Follow the principle of least privilege.</li>
              <li><strong>Monitor for Unusual Activity</strong> – Use logging and alerts to detect breaches early.</li>
            </ul>

            <p>The cloud is powerful, but security is a shared effort. Don't assume your data is safe—take proactive steps to protect it.</p>
            <p><strong>Stay vigilant, stay secure.</strong> 🔒</p>
          </div>`
            allPosts += eachPost;
        });
        $("#blog-posts").html(allPosts);
    }

}

var BlogPostService = {
    loadSinglePost: function() {
        // Extract id from hash, e.g. #single?id=1
        let postId = null;
        const hash = window.location.hash;
        if (hash.includes('?')) {
            postId = new URLSearchParams(hash.split('?')[1]).get('id');
        }
        if (!postId) return;

        RestClient.get(
            "posts/" + postId,
            function (response) {
                if (response && response.data) {
                    const post = response.data;
                    document.title = post.title;
                    $(".post-entry h1").text(post.title);
                    $("#single-post-content").html(`<p>${post.content}</p>`);
                } else {
                    $("#single-post-content").html("<p>Post not found.</p>");
                }
            },
            function (jqXHR) {
                const error = jqXHR.responseJSON?.message || "Error loading post.";
                $("#single-post-content").html(`<p>${error}</p>`);
                if (typeof toastr !== "undefined") {
                    toastr.error(error);
                }
            }
        );
    }
};
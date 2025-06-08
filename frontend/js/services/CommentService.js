// CommentService.js
// Service for fetching and rendering comments for a single post

var CommentService = {
    getCommentsByPostId: function(postId, callback) {
        RestClient.get(
            "comments/post/" + postId,
            function(response) {
                if (response && response.data) {
                    callback(response.data);
                } else {
                    callback([]);
                }
            },
            function(jqXHR) {
                toastr.error(jqXHR.responseJSON?.message || "Error loading comments.");
                callback([]);
            }
        );
    },

    renderComments: function(comments) {
        // Target the dynamic comments section
        var $commentsList = $("#dynamic-comments-list");
        var $commentsCount = $("#dynamic-comments-count");
        $commentsList.empty();
        $commentsCount.text(comments.length);

        if (!Array.isArray(comments) || comments.length === 0) {
            $commentsList.append('<li class="comment">No comments yet.</li>');
            return;
        }

        comments.forEach(function(comment) {
            // Format date as YYYY-MM-DD HH:MM
            var date = new Date(comment.created_at);
            var formattedDate = !isNaN(date.getTime())
                ? date.getFullYear() + '-' + String(date.getMonth()+1).padStart(2,'0') + '-' + String(date.getDate()).padStart(2,'0') + ' ' + String(date.getHours()).padStart(2,'0') + ':' + String(date.getMinutes()).padStart(2,'0')
                : comment.created_at;
            var author = comment.user_id ? 'User ' + comment.user_id : 'Anonymous';
            var content = comment.content || '';
            var html = `
                <li class="comment">
                    <div class="vcard">
                        <img src="../images/person_1.jpg" alt="User avatar">
                    </div>
                    <div class="comment-body">
                        <h3>${author}</h3>
                        <div class="meta">${formattedDate}</div>
                        <p>${content}</p>
                    </div>
                </li>
            `;
            $commentsList.append(html);
        });
    }
};

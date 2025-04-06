<?php

require_once __DIR__ . '/CommentDao.class.php';

$comment_dao = new CommentDao();

// Add a new comment
$new_comment = [
    "content" => "This is a test comment",
    "user_id" => 1, // Assuming a user with ID 1 exists
    "post_id" => 1  // Assuming a post with ID 1 exists
];

$added_comment = $comment_dao->addComment($new_comment);
print_r($added_comment);

// Get all comments
$comments = $comment_dao->getComments();
print_r($comments);

// Get a comment by ID
$comment_id = $added_comment['id'];
$comment = $comment_dao->getCommentByID($comment_id);
print_r($comment);

// Update the comment
$updated_comment = [
    "content" => "This is an updated test comment"
];
$comment_dao->editComment($comment_id, $updated_comment);
print_r($comment_dao->getCommentByID($comment_id));

// Delete the comment

?>
<?php

require_once __DIR__ . '/PostDao.class.php';

$post_dao = new PostDao();

// Add a new post
$new_post = [
    "title" => "Test Post Title",
    "content" => "This is the content of the test post.",
    "autor_id" => 1 
];

$added_post = $post_dao->addPost($new_post);
print_r($added_post);

// Get all posts
$posts = $post_dao->getPosts();
print_r($posts);

// Get a post by ID
$post_id = $added_post['id'];
$post = $post_dao->getPostByID($post_id);
print_r($post);

// Update the post
$updated_post = [
    "title" => "Updated Post Title",
    "content" => "This is the updated content of the test post."
];
$post_dao->editPost($post_id, $updated_post);
print_r($post_dao->getPostByID($post_id));

// Delete the post
$post_dao->deletePost($post_id);
print_r($post_dao->getPosts());

?>
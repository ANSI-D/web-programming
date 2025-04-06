<?php
require_once 'UserService.php';
require_once 'CategoryService.php';
require_once 'PostService.php';
require_once 'CommentService.php';
require_once 'LikeService.php';

// User Routes
Flight::route('GET /users', function() {
    Flight::json(Flight::userService()->getAll());
});

Flight::route('GET /users/@id', function($id) {
    Flight::json(Flight::userService()->getById($id));
});

Flight::route('POST /users', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->create($data));
});

Flight::route('PUT /users/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->update($id, $data));
});

Flight::route('DELETE /users/@id', function($id) {
    Flight::json(Flight::userService()->delete($id));
});

// Category Routes
Flight::route('GET /categories', function() {
    Flight::json(Flight::categoryService()->getAll());
});

Flight::route('GET /categories/@id', function($id) {
    Flight::json(Flight::categoryService()->getById($id));
});

Flight::route('POST /categories', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::categoryService()->create($data));
});

// Post Routes
Flight::route('GET /posts', function() {
    $author_id = Flight::request()->query['author_id'] ?? null;
    $category_id = Flight::request()->query['category_id'] ?? null;
    
    if ($author_id) {
        Flight::json(Flight::postService()->getByAuthor($author_id));
    } elseif ($category_id) {
        Flight::json(Flight::postService()->getByCategory($category_id));
    } else {
        Flight::json(Flight::postService()->getAll());
    }
});

Flight::route('GET /posts/@id', function($id) {
    Flight::json(Flight::postService()->getById($id));
});

Flight::route('POST /posts', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::postService()->create($data));
});

Flight::route('PUT /posts/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::postService()->update($id, $data));
});

Flight::route('PUT /posts/@id/publish', function($id) {
    Flight::json(Flight::postService()->publishPost($id));
});

// Comment Routes
Flight::route('GET /posts/@post_id/comments', function($post_id) {
    Flight::json(Flight::commentService()->getByPost($post_id));
});

Flight::route('POST /posts/@post_id/comments', function($post_id) {
    $data = Flight::request()->data->getData();
    $data['post_id'] = $post_id;
    Flight::json(Flight::commentService()->create($data));
});

// Like Routes
Flight::route('POST /comments/@comment_id/like', function($comment_id) {
    $user_id = Flight::request()->data->user_id; // Assuming user_id comes from auth
    Flight::json(Flight::likeService()->toggleLike($user_id, $comment_id));
});

Flight::route('GET /comments/@comment_id/likes', function($comment_id) {
    Flight::json([
        'likes' => Flight::likeService()->getLikesForComment($comment_id)
    ]);
});
?>
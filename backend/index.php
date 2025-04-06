<?php
require_once 'vendor/autoload.php'; 
require_once 'rest/dao/config.php';
require_once 'rest/dao/BaseDao.php';

Flight::register('userService', 'UserService');
Flight::register('categoryService', 'CategoryService');
Flight::register('postService', 'PostService');
Flight::register('commentService', 'CommentService');
Flight::register('likeService', 'LikeService');

require_once 'rest/routes/BlogRoutes.php';

Flight::map('error', function(Exception $ex) {
    Flight::json([
        'error' => $ex->getMessage(),
        'code' => $ex->getCode()
    ], 500);
});

Flight::map('notFound', function() {
    Flight::json(['error' => 'Endpoint not found'], 404);
});


Flight::start();
?>
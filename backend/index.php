<?php
require_once 'vendor/autoload.php'; 
require_once 'rest/dao/config.php';
require_once 'rest/dao/BaseDao.php';

// Register services
Flight::register('userService', 'UserService');
Flight::register('categoryService', 'CategoryService');
Flight::register('postService', 'PostService');
Flight::register('commentService', 'CommentService');
Flight::register('likeService', 'LikeService');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Error handler (catches both Exception and Error)
Flight::map('error', function(Throwable $ex) {
    $response = [
        'error' => $ex->getMessage(),
        'code' => $ex->getCode()
    ];
    
    // Add trace only in development
    if (getenv('ENVIRONMENT') === 'development') {
        $response['trace'] = $ex->getTrace();
    }
    
    Flight::json($response, 500);
});

// Not found handler
Flight::map('notFound', function() {
    Flight::json(['error' => 'Endpoint not found'], 404);
});

// CORS headers
Flight::before('start', function() {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type");
});

// Include routes
require_once 'rest/routes/BlogRoutes.php';

Flight::start();
<?php
require_once 'vendor/autoload.php'; 
require_once 'rest/config.php';
require_once 'rest/dao/BaseDao.class.php';
require_once 'rest/routes/user_routes.php';
require_once 'rest/routes/category_routes.php';
require_once 'rest/routes/comment_routes.php';
require_once 'rest/routes/post_routes.php';
require_once 'rest/routes/like_routes.php';
require_once 'rest/routes/middleware_routes.php';
require_once 'rest/routes/auth_routes.php';
require "middleware/AuthMiddleware.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::register('auth_service', "AuthService");
Flight::register('auth_middleware', "AuthMiddleware");

Flight::route('/*', function() {
   if(
       strpos(Flight::request()->url, '/auth/login') === 0 ||
       strpos(Flight::request()->url, '/auth/register') === 0
   ) {
       return TRUE;
   } else {
       try {
           $token = Flight::request()->getHeader("Authentication");
           if(Flight::auth_middleware()->verifyToken($token))
               return TRUE;
       } catch (\Exception $e) {
           Flight::halt(401, $e->getMessage());
       }
   }
});
require_once __DIR__ .'/rest/routes/auth_routes.php';


Flight::start();
?>
<?php
require_once 'vendor/autoload.php'; 
require_once 'rest/config.php';
require_once 'rest/dao/BaseDao.class.php';
require_once 'rest/routes/user_routes.php';
require_once 'rest/routes/category_routes.php';
require_once 'rest/routes/comment_routes.php';
require_once 'rest/routes/post_routes.php';
require_once 'rest/routes/like_routes.php';
require_once 'rest/routes/auth_routes.php';

Flight::start();
?>
<?php
require_once 'dao/UserDao.php';
require_once 'dao/CategoryDao.php';
require_once 'dao/PostDao.php';
require_once 'dao/CommentDao.php';
require_once 'dao/LikeDao.php';

$userDao = new UserDao();
$categoryDao = new CategoryDao();
$postDao = new PostDao();
$commentDao = new CommentDao();
$likeDao = new LikeDao();

// Insert a new user
$userDao->insert([
    'username' => 'johndoe',
    'email' => 'john@example.com',
    'password' => password_hash('password123', PASSWORD_DEFAULT),
    'role' => 'user'
]);

// Insert a category
$categoryDao->insert([
    'name' => 'Technology',
    'description' => 'Posts about technology'
]);

// Insert a post
$postDao->insert([
    'title' => 'First Post',
    'content' => 'This is my first post content',
    'autor_id' => 1,
    'category_id' => 1
]);

// Fetch all users
$users = $userDao->getAll();
print_r($users);

// Fetch all categories
$categories = $categoryDao->getAll();
print_r($categories);

// Fetch posts by author
$authorPosts = $postDao->getByAuthor(1);
print_r($authorPosts);
?>
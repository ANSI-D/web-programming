<?php

require_once __DIR__ . '/UserDao.class.php';

$user_dao = new UserDao();

// Add a new user
$new_user = [
    "username" => "John Doe",
    "email" => "johndoe@example.com",
    "password" => "password123",
    "role" => "user"
];

$added_user = $user_dao->addUser($new_user);
print_r($added_user);

// Get all users
$users = $user_dao->getUsers();
print_r($users);

// Get a user by ID
$user_id = $added_user['id'];
$user = $user_dao->getUserByID($user_id);
print_r($user);

// Update the user
$updated_user = [
    "username" => "John Smith",
    "email" => "johnsmith@example.com",
    "password" => "newpassword123",
    "role" => "admin"
];
$user_dao->editUser($user_id, $updated_user);
print_r($user_dao->getUserByID($user_id));

// Delete the user
// $user_dao->deleteUser($user_id);
// print_r($user_dao->getUsers());
?>
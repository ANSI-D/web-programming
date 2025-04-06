<?php

require_once __DIR__ . '/LikeDao.class.php';

$like_dao = new LikeDao();

// Add a new like
$new_like = [
    "id" => 1, // Assuming the ID is auto-generated or manually set
    "like_status" => 1 // Use a different key in the code

];

$added_like = $like_dao->addLike($new_like);
print_r($added_like);

// Get all likes
$likes = $like_dao->getLikes();
print_r($likes);

// Get a like by ID
$like_id = $added_like['id'];
$like = $like_dao->getLikeByID($like_id);
print_r($like);


?>
<?php

require_once __DIR__ . "/../dao/LikeDao.class.php";

class LikeService {
    private $likeDao;

    public function __construct() {
        $this->likeDao = new LikeDao();
    }

    public function addLike($like) {
        // Validate required fields
        if (!isset($like['user_id']) || !isset($like['comment_id'])) {
            throw new Exception("User ID and Comment ID are required");
        }

        // Check if user already liked this comment
        $existingLike = $this->getUserLikeStatusForComment($like['comment_id'], $like['user_id']);
        if ($existingLike) {
            throw new Exception("User already liked this comment");
        }

        // Add the like
        $likeData = [
            'user_id' => $like['user_id'],
            'comment_id' => $like['comment_id']
        ];

        return $this->likeDao->addLike($likeData);
    }

    public function getLikes() {
        return $this->likeDao->getLikes();
    }

    public function getLikeById($like_id) {
        return $this->likeDao->getLikeById($like_id);
    }

    public function deleteLike($like_id) {
        $this->likeDao->deleteLike($like_id);
    }

    public function getLikesByCommentId($comment_id) {
        return $this->likeDao->getLikesByCommentId($comment_id);
    }

    public function getLikesByUserId($user_id) {
        return $this->likeDao->getLikesByUserId($user_id);
    }

    public function deleteLikeByUserAndComment($user_id, $comment_id) {
        $this->likeDao->deleteLikeByUserAndComment($user_id, $comment_id);
    }

    public function getLikeCountForComment($comment_id) {
        return $this->likeDao->getLikeCountForComment($comment_id);
    }

    public function getUserLikeStatusForComment($comment_id, $user_id) {
        return $this->likeDao->getUserLikeStatusForComment($comment_id, $user_id);
    }
}
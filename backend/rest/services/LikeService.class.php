<?php

require_once __DIR__ . "/../dao/LikeDao.class.php";

class LikeService {
    private $likeDao;

    public function __construct() {
        $this->likeDao = new LikeDao();
    }

    public function addLike($like) {
        // Validate required fields
        if (!isset($like['like_status'])) {
            throw new Exception("Like status is required");
        }

        // Add additional business logic if needed
        $likeData = [
            'id' => $like['id'] ?? null,
            'like_status' => $like['like_status']
        ];

        return $this->likeDao->addLike($likeData);
    }

    public function getLikes() {
        $data = $this->likeDao->getLikes();
        return ["data" => $data];
    }

    public function getLikeById($like_id) {
        return $this->likeDao->getLikeByID($like_id);
    }

    public function deleteLike($like_id) {
        $this->likeDao->deleteLike($like_id);
    }

    // Additional method to get like count for a post
    public function getLikeCount($post_id) {
        $query = "SELECT COUNT(*) as like_count FROM likes WHERE post_id = :post_id";
        $result = $this->likeDao->query($query, ["post_id" => $post_id]);
        return $result[0]['like_count'] ?? 0;
    }

    // Additional method to check if user liked a post
    public function getUserLikeStatus($post_id, $user_id) {
        $query = "SELECT like_status FROM likes WHERE post_id = :post_id AND user_id = :user_id";
        $result = $this->likeDao->query_unique($query, [
            "post_id" => $post_id,
            "user_id" => $user_id
        ]);
        return $result['like_status'] ?? null;
    }
}
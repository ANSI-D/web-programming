<?php

require_once __DIR__ . "/BaseDao.class.php";

class LikeDao extends BaseDao {
    public function __construct() {
        parent::__construct("likes");
    }

    public function addLike($like) {
        return $this->insert("likes", [
            "user_id" => $like['user_id'],
            "comment_id" => $like['comment_id']
        ]);
    }

    public function getLikes() {
        $query = "SELECT * FROM likes";
        return $this->query($query, []);
    }

    public function getLikeByID($like_id) {
        $query = "SELECT * FROM likes WHERE id = :id";
        return $this->query_unique($query, [
            "id" => $like_id
        ]);
    }

    public function getLikesByCommentId($comment_id) {
        $query = "SELECT * FROM likes WHERE comment_id = :comment_id";
        return $this->query($query, [
            "comment_id" => $comment_id
        ]);
    }

    public function getLikesByUserId($user_id) {
        $query = "SELECT * FROM likes WHERE user_id = :user_id";
        return $this->query($query, [
            "user_id" => $user_id
        ]);
    }

    public function deleteLike($like_id) {
        $query = "DELETE FROM likes WHERE id = :id";
        $this->execute($query, [
            'id' => $like_id
        ]);
    }

    public function getLikeCountForComment($comment_id) {
        $query = "SELECT COUNT(*) as like_count FROM likes WHERE comment_id = :comment_id";
        $result = $this->query($query, ["comment_id" => $comment_id]);
        return $result[0]['like_count'] ?? 0;
    }
    
    public function getUserLikeStatusForComment($comment_id, $user_id) {
        $query = "SELECT id FROM likes WHERE comment_id = :comment_id AND user_id = :user_id";
        $result = $this->query_unique($query, [
            "comment_id" => $comment_id,
            "user_id" => $user_id
        ]);
        return $result ? true : false;
    }

    public function deleteLikeByUserAndComment($user_id, $comment_id) {
        $query = "DELETE FROM likes WHERE user_id = :user_id AND comment_id = :comment_id";
        $this->execute($query, [
            'user_id' => $user_id,
            'comment_id' => $comment_id
        ]);
    }
}
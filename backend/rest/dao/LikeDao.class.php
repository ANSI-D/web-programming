<?php

require_once __DIR__ . "/BaseDao.class.php";

class LikeDao extends BaseDao {
    public function __construct() {
        parent::__construct("likes");
    }

    public function addLike($like) {
        return $this->insert("likes", [
            "id" => $like['id'],
            "like" => $like['like_status']
        ]);
    }

    public function getLikes() {
        $query = "SELECT * 
        FROM likes";

        return $this->query($query, []);
    }

    public function getLikeByID($like_id) {
        $query = "SELECT * 
        FROM likes
        WHERE id = :id";

        return $this->query_unique($query, [
            "id" => $like_id
        ]);
    }

    public function deleteLike($like_id) {
        $query = "SELECT * FROM likes WHERE `like` = :like";
        $this->execute($query, [
            'id' => $like['id']
            
        ]);
    }
}

?>
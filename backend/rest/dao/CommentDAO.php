<?php
require_once 'BaseDao.php';

class CommentDao extends BaseDao {
    public function __construct() {
        parent::__construct("Comments");
    }

    public function getByPost($post_id) {
        $stmt = $this->connection->prepare("SELECT * FROM Comments WHERE post_id = :post_id");
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByUser($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM Comments WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
<?php
require_once 'BaseDao.php';

class PostDao extends BaseDao {
    public function __construct() {
        parent::__construct("Posts");
    }

    public function getByAuthor($author_id) {
        $stmt = $this->connection->prepare("SELECT * FROM Posts WHERE autor_id = :author_id");
        $stmt->bindParam(':author_id', $author_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByCategory($category_id) {
        $stmt = $this->connection->prepare("SELECT * FROM Posts WHERE category_id = :category_id");
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
<?php
// dao/LikeDAO.php

require_once __DIR__ . '/BaseDAO.php';

class LikeDAO extends BaseDAO {
    public function __construct() {
        parent::__construct();
        $this->table = 'Likes';
        $this->primaryKey = 'like_id';
    }
    
    // Create
    public function create($like) {
        // Check if like already exists
        if ($this->exists($like['user_id'], $like['comment_id'])) {
            return false;
        }
        
        $sql = "INSERT INTO {$this->table} (user_id, comment_id) 
                VALUES (:user_id, :comment_id)";
        $params = [
            ':user_id' => $like['user_id'],
            ':comment_id' => $like['comment_id']
        ];
        
        $this->executeQuery($sql, $params);
        return $this->conn->lastInsertId();
    }
    
    // Read (single)
    public function findById($id) {
        $sql = "SELECT l.*, u.username as user_name 
                FROM {$this->table} l
                JOIN Users u ON l.user_id = u.user_id
                WHERE l.{$this->primaryKey} = :id";
        $stmt = $this->executeQuery($sql, [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Check if like exists
    public function exists($userId, $commentId) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} 
                WHERE user_id = :user_id AND comment_id = :comment_id";
        $stmt = $this->executeQuery($sql, [
            ':user_id' => $userId,
            ':comment_id' => $commentId
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
    
    // Count likes for a comment
    public function countByComment($commentId) {
        $sql = "SELECT COUNT(*) as like_count FROM {$this->table} 
                WHERE comment_id = :comment_id";
        $stmt = $this->executeQuery($sql, [':comment_id' => $commentId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['like_count'];
    }
    
    // Delete
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        return $this->executeQuery($sql, [':id' => $id])->rowCount();
    }
    
    // Delete by user and comment
    public function deleteByUserAndComment($userId, $commentId) {
        $sql = "DELETE FROM {$this->table} 
                WHERE user_id = :user_id AND comment_id = :comment_id";
        return $this->executeQuery($sql, [
            ':user_id' => $userId,
            ':comment_id' => $commentId
        ])->rowCount();
    }
    
    // Delete all likes for a comment
    public function deleteByComment($commentId) {
        $sql = "DELETE FROM {$this->table} WHERE comment_id = :comment_id";
        return $this->executeQuery($sql, [':comment_id' => $commentId])->rowCount();
    }
}
?>
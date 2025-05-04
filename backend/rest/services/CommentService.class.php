<?php

require_once __DIR__ . "/../dao/CommentDao.class.php";

class CommentService {
    private $commentDao;

    public function __construct() {
        $this->commentDao = new CommentDao();
    }

    public function addComment($comment) {
        // Add any business logic here before inserting
        if (!isset($comment['content']) || empty($comment['content'])) {
            throw new Exception("Comment content cannot be empty");
        }
        
        // Set default values if needed
        if (!isset($comment['created_at'])) {
            $comment['created_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->commentDao->addComment($comment);
    }

    public function getComments() {
        $data = $this->commentDao->getComments();
        return ["data" => $data];
    }

    public function getCommentById($comment_id) {
        return $this->commentDao->getCommentByID($comment_id);
    }

    public function deleteComment($comment_id) {
        $this->commentDao->deleteComment($comment_id);
    }

    public function editComment($comment) {
        $comment_id = $comment['id'];
        unset($comment['id']);

        if (!isset($comment['content']) || empty($comment['content'])) {
            throw new Exception("Comment content cannot be empty");
        }

        $this->commentDao->editComment($comment_id, $comment);
    }

    // Additional method to get comments by post ID
    public function getCommentsByPostId($post_id) {
        $query = "SELECT * FROM comments WHERE post_id = :post_id";
        return $this->commentDao->query($query, ["post_id" => $post_id]);
    }
}
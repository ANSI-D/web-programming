<?php

require_once __DIR__ . "/BaseDao.class.php";

class CommentDao extends BaseDao {
    public function __construct() {
        parent::__construct("comments");
    } 

    public function addComment($comment) {
        return $this->insert("comments", $comment);
    }    

    public function getComments() {
        $query = "SELECT * 
        FROM comments";

        return $this->query($query, []);
    }

    public function getCommentByID($comment_id) {
        $query = "SELECT * 
        FROM comments
        WHERE id = :id";

        return $this->query_unique($query, [
            "id" => $comment_id
        ]);
    }

    public function deleteComment($comment_id) {
        $query = "DELETE FROM comments WHERE id = :id";
        $this->execute($query, [
            'id' => $comment_id
        ]);
    }

    public function editComment($comment_id, $comment) {
        $query = "UPDATE comments SET content = :content WHERE id = :id";

        $this->execute($query, [
            'id' => $comment_id,
            'content' => $comment['content']
            
        ]);
    }
}

?>
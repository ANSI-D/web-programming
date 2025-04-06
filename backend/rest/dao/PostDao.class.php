<?php

require_once __DIR__ . "/BaseDao.class.php";

class PostDao extends BaseDao {
    public function __construct() {
        parent::__construct("posts");
    } 

    public function addPost($post) {
        return $this->insert("posts", $post);
    }    

    public function getPosts() {
        $query = "SELECT * 
        FROM posts";

        return $this->query($query, []);
    }

    public function getPostByID($post_id) {
        $query = "SELECT * 
        FROM posts
        WHERE id = :id";

        return $this->query_unique($query, [
            "id" => $post_id
        ]);
    }

    public function deletePost($post_id) {
        $query = "DELETE FROM posts WHERE id = :id";
        $this->execute($query, [
            'id' => $post_id
        ]);
    }

    public function editPost($post_id, $post) {
        $query = "UPDATE posts SET title = :title, content = :content WHERE id = :id";

        $this->execute($query, [
            'id' => $post_id,
            'title' => $post['title'],
            'content' => $post['content']
            
        ]);
    }
}

?>
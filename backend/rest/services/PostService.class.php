<?php

require_once __DIR__ . "/../dao/PostDao.class.php";

class PostService {
    private $postDao;    public function __construct() {
        $this->postDao = new PostDao();
    }

    public function addPost($post) {
        // Set fixed autor_id = 1 as per requirements
        $post['autor_id'] = 1;
        
        // Set published_at to current timestamp
        $post['published_at'] = date('Y-m-d H:i:s');
        
        // Set updated_at to current timestamp
        $post['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->postDao->addPost($post);
    }

    public function getPosts() {
        $data = $this->postDao->getPosts();
        return ["data" => $data];
    }

    public function getPostById($post_id) {
        return $this->postDao->getPostByID($post_id);
    }

    public function deletePost($post_id) {
        $this->postDao->deletePost($post_id);
    }

    public function editPost($post) {
        $post_id = $post['id'];
        unset($post['id']);

        $this->postDao->editPost($post_id, $post);
    }
}

?>
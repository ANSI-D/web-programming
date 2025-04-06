<?php
require_once '../dao/PostDao.php';
require_once 'BaseService.php';


class PostService extends BaseService {
    public function __construct() {
        parent::__construct(new PostDao());
    }

    public function getByAuthor($author_id) {
        return $this->dao->getByAuthor($author_id);
    }

    public function getByCategory($category_id) {
        return $this->dao->getByCategory($category_id);
    }

    public function publishPost($id) {
        return $this->dao->update($id, ['published_at' => date('Y-m-d H:i:s')]);
    }
}
?>
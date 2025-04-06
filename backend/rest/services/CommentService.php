<?php
require_once 'CommentDao.php';

class CommentService extends BaseService {
    public function __construct() {
        parent::__construct(new CommentDao());
    }

    public function getByPost($post_id) {
        return $this->dao->getByPost($post_id);
    }

    public function getByUser($user_id) {
        return $this->dao->getByUser($user_id);
    }
}
?>
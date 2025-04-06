<?php
require_once '../dao/LikeDao.php';
require_once 'BaseService.php';


class LikeService extends BaseService {
    public function __construct() {
        parent::__construct(new LikeDao());
    }

    public function getLikesForComment($comment_id) {
        return $this->dao->getLikesForComment($comment_id);
    }

    public function userLikedComment($user_id, $comment_id) {
        return $this->dao->userLikedComment($user_id, $comment_id);
    }

    public function toggleLike($user_id, $comment_id) {
        if ($this->userLikedComment($user_id, $comment_id)) {
            // Unlike if already liked
            return $this->dao->deleteLike($user_id, $comment_id);
        } else {
            // Like if not already liked
            return $this->dao->insert([
                'user_id' => $user_id,
                'comment_id' => $comment_id
            ]);
        }
    }
}
?>
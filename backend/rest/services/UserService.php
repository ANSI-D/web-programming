<?php
require_once 'UserDao.php';

class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserDao());
    }

    public function getByEmail($email) {
        return $this->dao->getByEmail($email);
    }

    public function getByUsername($username) {
        return $this->dao->getByUsername($username);
    }
}
?>
<?php
require_once '../dao/UserDao.php';
require_once 'BaseService.php';

class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserDao());
    }


    public function addUser($userData) {
    
        if (empty($userData['username']) || empty($userData['email']) || empty($userData['password'])) {
            throw new Exception('Username, email and password are required');
        }

        
        if ($this->dao->getByEmail($userData['email'])) {
            throw new Exception('Email already exists');
        }
        if ($this->dao->getByUsername($userData['username'])) {
            throw new Exception('Username already exists');
        }

        
        $userData['password'] = password_hash($userData['password'], PASSWORD_BCRYPT);
        $userData['role'] = $userData['role'] ?? 'user';

        return $this->dao->addUser($userData);
    }

    
    public function getUsers() {
        return $this->dao->getUsers();
    }

    
    public function getUserById($id) {
        $user = $this->dao->getUserById($id);
        if (!$user) {
            throw new Exception('User not found');
        }
        return $user;
    }

    
    public function deleteUser($id) {
        if (!$this->dao->getUserById($id)) {
            throw new Exception('User not found');
        }
        return $this->dao->deleteUser($id);
    }

    
    public function editUser($id, $userData) {
        if (!$this->dao->getUserById($id)) {
            throw new Exception('User not found');
        }

        
        if (isset($userData['password'])) {
            $userData['password'] = password_hash($userData['password'], PASSWORD_BCRYPT);
        }

        return $this->dao->editUser($id, $userData);
    }

    public function getByEmail($email) {
        return $this->dao->getByEmail($email);
    }

    public function getByUsername($username) {
        return $this->dao->getByUsername($username);
    }
}
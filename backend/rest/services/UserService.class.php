<?php

require_once __DIR__ . "/../dao/UserDao.class.php";

class UserService {
    private $userDao;

    public function __construct() {
        $this->userDao = new UserDao();
    }

    public function addUser($user) {
        // Add any business logic here (e.g., password hashing)
        if (isset($user['password'])) {
            $user['password'] = password_hash($user['password'], PASSWORD_BCRYPT);
        }
        return $this->userDao->addUser($user);
    }

    public function getUsers() {
        $data = $this->userDao->getUsers();
        return ["data" => $data];
    }

    public function getUserById($user_id) {
        return $this->userDao->getUserByID($user_id);
    }

    public function deleteUser($user_id) {
        $this->userDao->deleteUser($user_id);
    }

    public function editUser($user) {
        $user_id = $user['id'];
        unset($user['id']);

        // Handle password hashing if password is being updated
        if (isset($user['password']) && !empty($user['password'])) {
            $user['password'] = password_hash($user['password'], PASSWORD_BCRYPT);
        } else {
            // Don't update password if not provided
            unset($user['password']);
        }

        $this->userDao->editUser($user_id, $user);
    }

    // Additional method for authentication
    public function authenticate($email, $password) {
        $user = $this->userDao->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
?>
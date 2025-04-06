<?php

require_once __DIR__ . "/BaseDao.class.php";

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct("users");
    } 

    public function addUser($user) {
        return $this->insert("users", $user);
    }    

    public function getUsers() {
        $query = "SELECT * 
        FROM users";

        return $this->query($query, []);
    }

    public function getUserByID($user_id) {
        $query = "SELECT * 
        FROM users
        WHERE id = :id";

        return $this->query_unique($query, [
            "id" => $user_id
        ]);
    }

    public function deleteUser($user_id) {
        $query = "DELETE FROM users WHERE id = :id";
        $this->execute($query, [
            'id' => $user_id
        ]);
    }

    public function editUser($user_id, $user) {
        $query = "UPDATE users SET username = :username, email = :email, password = :password, role = :role WHERE id = :id";

        $this->execute($query, [
            'id' => $user_id,
            'username' => $user['username'],
            'email' => $user['email'],
            'password' => $user['password'],
            'role' => $user['role']
        ]);
    }
}

?>
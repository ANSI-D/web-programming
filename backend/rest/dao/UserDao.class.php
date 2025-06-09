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
    }    public function editUser($user_id, $user) {
        // Build query dynamically based on available fields
        $fields = [];
        $params = ['id' => $user_id];
        
        if (isset($user['username'])) {
            $fields[] = "username = :username";
            $params['username'] = $user['username'];
        }
        
        if (isset($user['email'])) {
            $fields[] = "email = :email";
            $params['email'] = $user['email'];
        }
        
        if (isset($user['password'])) {
            $fields[] = "password = :password";
            $params['password'] = $user['password'];
        }
        
        if (isset($user['role'])) {
            $fields[] = "role = :role";
            $params['role'] = $user['role'];
        }
        
        if (empty($fields)) {
            return; // Nothing to update
        }
        
        $query = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $this->execute($query, $params);
    }
    public function getUserByEmail($email) {
        $query = "SELECT * 
        FROM users
        WHERE email = :email";
    
        return $this->query_unique($query, [
            "email" => $email
        ]);
    }
}

?>
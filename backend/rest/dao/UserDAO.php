<?php
require_once 'BaseDao.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct("users");
    }

    // Add new user
    public function addUser($userData) {
        $stmt = $this->connection->prepare(
            "INSERT INTO users (username, email, password, role) 
            VALUES (:username, :email, :password, :role)"
        );
        
        $stmt->execute([
            ':username' => $userData['username'],
            ':email' => $userData['email'],
            ':password' => $userData['password'],
            ':role' => $userData['role'] ?? 'user'
        ]);
        
        return $this->connection->lastInsertId();
    }

    // Get all users
    public function getUsers() {
        $stmt = $this->connection->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get single user by ID
    public function getUserById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Delete user
    public function deleteUser($id) {
        $stmt = $this->connection->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Edit user
    public function editUser($id, $userData) {
        $query = "UPDATE users SET ";
        $params = [':id' => $id];
        $updates = [];
        
        foreach ($userData as $key => $value) {
            $updates[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        
        $query .= implode(', ', $updates) . " WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute($params);
    }

    // Additional required methods used by Service
    public function getByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function getByUsername($username) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
    }
}
<?php

require_once __DIR__ . '/../../system/Database.php';
require_once __DIR__ . '/../models/UserModel.php';

class UserDAO {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findByUsername($username) {
        $query = "SELECT id, username, password FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new UserModel($row['id'], $row['username'], $row['password']);
        }
        return null;
    }

    public function createUser($username, $password) {
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($query);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

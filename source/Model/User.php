<?php
namespace App\Model;

use App\Config\Database;

class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
    
    public function createUser($username, $password) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("
                INSERT INTO users (username, password, role) 
                VALUES (?, ?, 'user')
            ");
            return $stmt->execute([$username, $hashedPassword]);
        } catch (\PDOException $e) {
            return false;
        }
    }
} 
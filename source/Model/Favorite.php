<?php
namespace App\Model;

use App\Config\Database;

class Favorite {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getFavorites($userId) {
        $stmt = $this->db->prepare("
            SELECT f.* 
            FROM foods f
            JOIN favorites fav ON f.id = fav.food_id
            WHERE fav.user_id = ?
            ORDER BY fav.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    public function getFavoriteIds($userId) {
        $stmt = $this->db->prepare("
            SELECT food_id FROM favorites 
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        return array_column($stmt->fetchAll(), 'food_id');
    }
    
    public function exists($userId, $foodId) {
        $stmt = $this->db->prepare("
            SELECT id FROM favorites 
            WHERE user_id = ? AND food_id = ?
        ");
        $stmt->execute([$userId, $foodId]);
        return $stmt->fetch() !== false;
    }
    
    public function add($userId, $foodId) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO favorites (user_id, food_id) 
                VALUES (?, ?)
            ");
            return $stmt->execute([$userId, $foodId]);
        } catch (\PDOException $e) {
            return false;
        }
    }
    
    public function remove($userId, $foodId) {
        $stmt = $this->db->prepare("
            DELETE FROM favorites 
            WHERE user_id = ? AND food_id = ?
        ");
        return $stmt->execute([$userId, $foodId]);
    }
} 
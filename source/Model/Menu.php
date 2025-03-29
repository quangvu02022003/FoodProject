<?php
namespace App\Model;

use App\Config\Database;

class Menu {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function create($userId, $name, $type) {
        $stmt = $this->db->prepare("
            INSERT INTO menus (user_id, name, type) 
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$userId, $name, $type]);
        return $this->db->lastInsertId();
    }
    
    public function addFoodToMenu($menuId, $foodId) {
        $stmt = $this->db->prepare("INSERT INTO menu_items (menu_id, food_id) VALUES (?, ?)");
        return $stmt->execute([$menuId, $foodId]);
    }
    
    public function removeFoodFromMenu($menuId, $foodId) {
        $stmt = $this->db->prepare("
            DELETE FROM menu_items 
            WHERE menu_id = ? AND food_id = ?
        ");
        return $stmt->execute([$menuId, $foodId]);
    }
    
    public function getUserMenus($userId) {
        $stmt = $this->db->prepare("
            SELECT m.*, COUNT(mi.id) as food_count
            FROM menus m
            LEFT JOIN menu_items mi ON m.id = mi.menu_id
            WHERE m.user_id = ?
            GROUP BY m.id
            ORDER BY m.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    public function getMenuFoods($menuId) {
        $stmt = $this->db->prepare("
            SELECT f.* 
            FROM foods f
            JOIN menu_items mi ON f.id = mi.food_id
            WHERE mi.menu_id = ?
            ORDER BY mi.created_at DESC
        ");
        $stmt->execute([$menuId]);
        return $stmt->fetchAll();
    }
    
    public function getMenuById($menuId, $userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM menus 
            WHERE id = ? AND user_id = ?
        ");
        $stmt->execute([$menuId, $userId]);
        return $stmt->fetch();
    }
    
    public function deleteMenu($id) {
        $stmt = $this->db->prepare("DELETE FROM menus WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function checkFoodInMenu($menuId, $foodId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM menu_items 
            WHERE menu_id = ? AND food_id = ?
        ");
        $stmt->execute([$menuId, $foodId]);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
} 
<?php
namespace App\Model;

use App\Config\Database;

class Food {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAllFoods($limit = null, $offset = null) {
        if ($limit !== null) {
            $limit = (int)$limit;
            $offset = (int)$offset;
            
            $stmt = $this->db->query("
                SELECT id, name, description, instructions, image_url 
                FROM foods 
                ORDER BY id DESC
                LIMIT $limit OFFSET $offset
            ");
        } else {
            $stmt = $this->db->query("
                SELECT id, name, description, instructions, image_url 
                FROM foods 
                ORDER BY id DESC
            ");
        }
        
        return $stmt->fetchAll();
    }
    
    public function getFoodById($id) {
        $stmt = $this->db->prepare("SELECT * FROM foods WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO foods (name, description, ingredients, instructions, image_url) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['ingredients'],
            $data['instructions'],
            $data['image_url']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE foods 
            SET name = ?, 
                description = ?,
                ingredients = ?,
                instructions = ?, 
                image_url = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['ingredients'],
            $data['instructions'],
            $data['image_url'],
            $id
        ]);
    }

    public function checkFavorites($id) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count
            FROM favorites 
            WHERE food_id = ?
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }

    public function delete($id) {
        try {
            // Kiểm tra xem món ăn có trong danh sách yêu thích không
            $hasFavorites = $this->checkFavorites($id);
            if ($hasFavorites) {
                return [
                    'success' => false, 
                    'hasFavorites' => true,
                    'message' => 'Món ăn này đang nằm trong danh sách yêu thích. Bạn có chắc muốn xóa?'
                ];
            }

            // Nếu không có trong danh sách yêu thích, xóa luôn
            return $this->forceDelete($id);
            
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function forceDelete($id) {
        try {
            // Bắt đầu transaction
            $this->db->beginTransaction();
            
            // Xóa tất cả các liên kết trong bảng favorites trước
            $stmt = $this->db->prepare("DELETE FROM favorites WHERE food_id = ?");
            $stmt->execute([$id]);
            
            // Sau đó xóa món ăn
            $stmt = $this->db->prepare("DELETE FROM foods WHERE id = ?");
            $stmt->execute([$id]);
            
            // Commit transaction
            $this->db->commit();
            return ['success' => true];
            
        } catch (\Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function searchFoods($keyword) {
        $keyword = "%$keyword%";
        $stmt = $this->db->prepare("
            SELECT id, name, description, ingredients, instructions, image_url 
            FROM foods 
            WHERE name LIKE ? 
            ORDER BY id DESC
        ");
        $stmt->execute([$keyword]);
        return $stmt->fetchAll();
    }

    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM foods");
        $result = $stmt->fetch();
        return $result['total'];
    }
} 
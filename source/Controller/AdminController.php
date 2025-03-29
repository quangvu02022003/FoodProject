<?php
namespace App\Controller;

use App\Model\Food;

class AdminController {
    private $foodModel;
    
    public function __construct() {
        $this->foodModel = new Food();
    }
    
    public function index() {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (!empty($keyword)) {
            $foods = $this->foodModel->searchFoods($keyword);
        } else {
            $foods = $this->foodModel->getAllFoods();
        }
        
        require 'views/admin/foods/index.php';
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
                'ingredients' => $_POST['ingredients'] ?? '',
                'instructions' => $_POST['instructions'] ?? '',
                'image_url' => ''
            ];
            
            // Xử lý upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/uploads/';
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $uploadFile = $uploadDir . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image_url'] = $uploadFile;
                }
            }
            
            if ($this->foodModel->create($data)) {
                header('Location: /index.php/admin/foods');
                exit;
            }
        }
        
        require 'views/admin/foods/add.php';
    }
    
    public function edit($id) {
        $food = $this->foodModel->getFoodById($id);
        
        if (!$food) {
            header('Location: /index.php/admin/foods');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
                'ingredients' => $_POST['ingredients'] ?? '',
                'instructions' => $_POST['instructions'] ?? '',
                'image_url' => $food['image_url']
            ];
            
            // Xử lý upload ảnh mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/uploads/';
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $uploadFile = $uploadDir . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    // Xóa ảnh cũ nếu tồn tại
                    if (file_exists($food['image_url'])) {
                        unlink($food['image_url']);
                    }
                    $data['image_url'] = $uploadFile;
                }
            }
            
            if ($this->foodModel->update($id, $data)) {
                header('Location: /index.php/admin/foods');
                exit;
            }
        }
        
        require 'views/admin/foods/edit.php';
    }
    
    public function delete($id) {
        $food = $this->foodModel->getFoodById($id);
        
        if ($food) {
            $result = $this->foodModel->delete($id);
            
            if (!$result['success'] && isset($result['hasFavorites'])) {
                // Nếu món ăn có trong danh sách yêu thích
                $_SESSION['confirm_delete'] = [
                    'id' => $id,
                    'message' => $result['message']
                ];
            } else if (!$result['success']) {
                $_SESSION['error'] = $result['message'];
            } else {
                // Xóa file ảnh nếu tồn tại
                if (file_exists($food['image_url'])) {
                    unlink($food['image_url']);
                }
                $_SESSION['success'] = 'Đã xóa món ăn thành công';
            }
        }
        
        header('Location: /index.php/admin/foods');
        exit;
    }
    
    public function forceDelete($id) {
        $food = $this->foodModel->getFoodById($id);
        
        if ($food) {
            $result = $this->foodModel->forceDelete($id);
            if (!$result['success']) {
                $_SESSION['error'] = $result['message'];
            } else {
                if (file_exists($food['image_url'])) {
                    unlink($food['image_url']);
                }
                $_SESSION['success'] = 'Đã xóa món ăn thành công';
            }
        }
        
        header('Location: /index.php/admin/foods');
        exit;
    }
} 
<?php
namespace App\Controller;

use App\Model\Favorite;

class FavoriteController {
    private $favoriteModel;
    
    public function __construct() {
        $this->favoriteModel = new Favorite();
    }
    
    public function toggle($foodId) {
        if (!isset($_SESSION['user_id'])) {
            if ($this->isAjaxRequest()) {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                exit;
            }
            header('Location: /index.php/login');
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $success = false;
        
        if ($this->favoriteModel->exists($userId, $foodId)) {
            $success = $this->favoriteModel->remove($userId, $foodId);
        } else {
            $success = $this->favoriteModel->add($userId, $foodId);
        }
        
        if ($this->isAjaxRequest()) {
            echo json_encode(['success' => $success]);
            exit;
        }
        
        // Nếu không phải AJAX request, redirect về trang trước
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    private function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php/login');
            exit;
        }
        
        $favorites = $this->favoriteModel->getFavorites($_SESSION['user_id']);
        require 'views/favorites/index.php';
    }
} 
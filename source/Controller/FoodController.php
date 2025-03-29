<?php
namespace App\Controller;

use App\Model\Food;
use App\Model\Favorite;
use App\Helper\Pagination;

class FoodController {
    private $foodModel;
    
    public function __construct() {
        $this->foodModel = new Food();
    }
    
    public function index($page = 1) {
        $totalItems = $this->foodModel->count();
        $pagination = new Pagination($totalItems, 6, $page);
        
        $foods = $this->foodModel->getAllFoods(
            $pagination->getLimit(), 
            $pagination->getOffset()
        );
        
        $favorites = [];
        if (isset($_SESSION['user_id'])) {
            $favoriteModel = new Favorite();
            $favorites = $favoriteModel->getFavoriteIds($_SESSION['user_id']);
        }
        
        require 'views/foods/index.php';
    }
    
    public function show($id) {
        $food = $this->foodModel->getFoodById($id);
        if (!$food) {
            header('Location: /index.php');
            return;
        }
        require 'views/foods/show.php';
    }
    
    public function search() {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (empty($keyword)) {
            header('Location: /index.php');
            return;
        }
        
        $foods = $this->foodModel->searchFoods($keyword);
        $favorites = [];
        
        if (isset($_SESSION['user_id'])) {
            $favoriteModel = new Favorite();
            $favorites = $favoriteModel->getFavoriteIds($_SESSION['user_id']);
        }
        
        require 'views/foods/search.php';
    }
} 
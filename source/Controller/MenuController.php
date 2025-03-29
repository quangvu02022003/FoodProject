<?php
namespace App\Controller;

use App\Model\Menu;
use App\Model\Food;

class MenuController {
    private $menuModel;
    private $foodModel;
    
    public function __construct() {
        $this->menuModel = new Menu();
        $this->foodModel = new Food();
    }
    
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php/login');
            exit;
        }
        
        $menus = $this->menuModel->getUserMenus($_SESSION['user_id']);
        require 'views/menus/index.php';
    }
    
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            if ($this->isAjaxRequest()) {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                exit;
            }
            header('Location: /index.php/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý JSON request từ form tạo menu trong trang yêu thích
            if ($this->isAjaxRequest()) {
                $json = file_get_contents('php://input');
                $data = json_decode($json, true);
                
                if (!$data || empty($data['name']) || empty($data['type']) || empty($data['foods'])) {
                    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                    exit;
                }

                try {
                    $menuId = $this->menuModel->create($_SESSION['user_id'], $data['name'], $data['type']);
                    
                    foreach ($data['foods'] as $foodId) {
                        $this->menuModel->addFoodToMenu($menuId, $foodId);
                    }
                    
                    echo json_encode(['success' => true]);
                    exit;
                } catch (\Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                    exit;
                }
            }
            
            // Xử lý form submit thông thường
            $name = $_POST['name'] ?? '';
            $type = $_POST['type'] ?? '';
            
            if (empty($name) || empty($type)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
                header('Location: /index.php/menus/create');
                exit;
            }
            
            try {
                $menuId = $this->menuModel->create($_SESSION['user_id'], $name, $type);
                header('Location: /index.php/menus');
                exit;
            } catch (\Exception $e) {
                $_SESSION['error'] = 'Có lỗi xảy ra khi tạo menu';
                header('Location: /index.php/menus/create');
                exit;
            }
        }

        require 'views/menus/create.php';
    }
    
    public function show($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php/login');
            exit;
        }
        
        $menu = $this->menuModel->getMenuById($id, $_SESSION['user_id']);
        if (!$menu) {
            header('Location: /index.php/menus');
            exit;
        }
        
        $foods = $this->menuModel->getMenuFoods($id);
        require 'views/menus/show.php';
    }
    
    public function addFood() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        // Đọc JSON từ request
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $menuId = $data['menu_id'] ?? null;
        $foodId = $data['food_id'] ?? null;

        if (!$menuId || !$foodId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin']);
            exit;
        }

        try {
            // Kiểm tra xem menu có thuộc về user không
            $menu = $this->menuModel->getMenuById($menuId, $_SESSION['user_id']);
            if (!$menu) {
                echo json_encode(['success' => false, 'message' => 'Menu không tồn tại']);
                exit;
            }

            $success = $this->menuModel->addFoodToMenu($menuId, $foodId);
            echo json_encode(['success' => $success]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
    
    public function removeFood() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        // Đọc JSON từ request
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $menuId = $data['menu_id'] ?? null;
        $foodId = $data['food_id'] ?? null;

        if (!$menuId || !$foodId) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin']);
            exit;
        }

        try {
            // Kiểm tra xem menu có thuộc về user không
            $menu = $this->menuModel->getMenuById($menuId, $_SESSION['user_id']);
            if (!$menu) {
                echo json_encode(['success' => false, 'message' => 'Menu không tồn tại']);
                exit;
            }

            $success = $this->menuModel->removeFoodFromMenu($menuId, $foodId);
            echo json_encode(['success' => $success]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
    
    public function delete($id) {
        $menuModel = new Menu();
        $result = $menuModel->deleteMenu($id); // Gọi phương thức xóa menu

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            // Ghi lại lỗi
            error_log("Failed to delete menu with ID: $id");
            echo json_encode(['success' => false]);
        }
    }
    
    public function addFoodToMenu($menuId) {
        $data = json_decode(file_get_contents("php://input"), true);
        $foodId = $data['food_id'];

        $menuModel = new Menu();
        $result = $menuModel->addFoodToMenu($menuId, $foodId); // Gọi phương thức thêm món ăn vào menu

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            error_log("Failed to add food with ID: $foodId to menu with ID: $menuId");
            echo json_encode(['success' => false]);
        }
    }
    
    private function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
} 
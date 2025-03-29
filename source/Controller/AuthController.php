<?php
namespace App\Controller;

use App\Model\User;
use App\Config\Database;

class AuthController {
    private $userModel;
    private $db;
    
    public function __construct() {
        $this->userModel = new User();
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function showLogin() {
        require 'views/auth/login.php';
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $user = $this->userModel->getUserByUsername($username);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Luôn chuyển hướng về trang chủ sau khi đăng nhập
                header('Location: /index.php');
                exit;
            } else {
                $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không đúng';
                header('Location: /index.php/login');
                exit;
            }
        }
        
        require 'views/auth/login.php';
    }
    
    public function showRegister() {
        require 'views/auth/register.php';
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validate input
            if (empty($username) || empty($password) || empty($confirmPassword)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
                header('Location: /index.php/register');
                exit;
            }

            // Check password match
            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Mật khẩu xác nhận không khớp';
                header('Location: /index.php/register');
                exit;
            }

            // Check username length
            if (strlen($username) < 3) {
                $_SESSION['error'] = 'Tên đăng nhập phải có ít nhất 3 ký tự';
                header('Location: /index.php/register');
                exit;
            }

            // Check password length
            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Mật khẩu phải có ít nhất 6 ký tự';
                header('Location: /index.php/register');
                exit;
            }

            try {
                // Kiểm tra username đã tồn tại
                if ($this->userModel->getUserByUsername($username)) {
                    $_SESSION['error'] = 'Tên đăng nhập đã tồn tại';
                    header('Location: /index.php/register');
                    exit;
                }

                // Tạo tài khoản mới
                if ($this->userModel->createUser($username, $password)) {
                    $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
                    header('Location: /index.php/login');
                    exit;
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                    header('Location: /index.php/register');
                    exit;
                }
            } catch (\PDOException $e) {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                header('Location: /index.php/register');
                exit;
            }
        }

        require 'views/auth/register.php';
    }
    
    public function logout() {
        session_destroy();
        header('Location: ../login');
    }
} 
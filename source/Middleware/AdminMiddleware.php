<?php
namespace App\Middleware;

class AdminMiddleware {
    public static function isAdmin() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /index.php/login');
            exit;
        }
    }
} 
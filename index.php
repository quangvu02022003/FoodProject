<?php
session_start();

require 'vendor/autoload.php';
require 'source/Config/config.php';

use App\Controller\FoodController;
use App\Controller\AuthController;
use App\Controller\AdminController;
use App\Controller\FavoriteController;
use App\Controller\MenuController;

$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);
$parts = explode('/', trim($path, '/'));

// Bỏ qua phần index.php trong URL
if ($parts[0] === 'index.php') {
    array_shift($parts);
}

// Router
switch ($parts[0] ?? '') {
    case '':
        if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
            $controller = new AdminController();
            $controller->index();
        } else {
            $controller = new FoodController();
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $controller->index($page);
        }
        break;

    case 'food':
        if (isset($parts[1])) {
            $controller = new FoodController();
            $controller->show($parts[1]);
        }
        break;

    case 'search':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $controller = new FoodController();
            $controller->search();
        } else {
            header('Location: /index.php/admin/foods');
            exit;
        }
        break;

    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;

    case 'register':
        $controller = new AuthController();
        $controller->register();
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'admin':
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /index.php/login');
            exit;
        }
        $controller = new AdminController();
        if ($parts[1] === 'foods') {
            if (!isset($parts[2])) {
                $controller->index();
            } else if ($parts[2] === 'add') {
                $controller->add();
            } else if ($parts[2] === 'edit' && isset($parts[3])) {
                $controller->edit($parts[3]);
            } else if ($parts[2] === 'delete' && isset($parts[3])) {
                $controller->delete($parts[3]);
            } else if ($parts[2] === 'force-delete' && isset($parts[3])) {
                $controller->forceDelete($parts[3]);
            }
        }
        break;

    case 'favorites':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php/login');
            exit;
        }
        if ($_SESSION['role'] === 'admin') {
            header('Location: /index.php/admin/foods');
            exit;
        }
        $controller = new FavoriteController();
        if (!isset($parts[1])) {
            $controller->index();
        } else if ($parts[1] === 'toggle' && isset($parts[2])) {
            $controller->toggle($parts[2]);
        }
        break;

    case 'menus':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php/login');
            exit;
        }
        if ($_SESSION['role'] === 'admin') {
            header('Location: /index.php/admin/foods');
            exit;
        }
        $controller = new MenuController();
        if (!isset($parts[1])) {
            $controller->index();
        } else if ($parts[1] === 'create') {
            $controller->create();
        } else if ($parts[1] === 'show' && isset($parts[2])) {
            $controller->show($parts[2]);
        } else if ($parts[1] === 'add-food') {
            $controller->addFood();
        } else if ($parts[1] === 'remove-food') {
            $controller->removeFood();
        }
        break;

    default:
        http_response_code(404);
        require 'views/404.php';
        break;
}
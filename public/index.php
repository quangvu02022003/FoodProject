<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\FoodController;
use App\Controller\AuthController;
use App\Controller\FavoriteController;
use App\Router;

require __DIR__ . '/../source/routes.php';

$router->match($_SERVER['REQUEST_URI']); 
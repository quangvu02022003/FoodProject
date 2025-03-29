<?php
namespace App;

$router = new Router();

// Route cho món ăn
$router->addRoute('GET', '/', 'FoodController@index');
$router->addRoute('GET', '/foods', 'FoodController@index');
$router->addRoute('GET', '/food/{id}', 'FoodController@show');
$router->addRoute('GET', '/search', 'FoodController@search');

// Route cho authentication
$router->addRoute('GET', '/login', 'AuthController@showLogin');
$router->addRoute('POST', '/login', 'AuthController@login');
$router->addRoute('GET', '/register', 'AuthController@showRegister');
$router->addRoute('POST', '/register', 'AuthController@register');
$router->addRoute('GET', '/logout', 'AuthController@logout');

// Route cho menu yêu thích
$router->addRoute('POST', '/favorites/add/{id}', 'FavoriteController@add');
$router->addRoute('GET', '/favorites', 'FavoriteController@index');
$router->addRoute('POST', '/favorites/remove/{id}', 'FavoriteController@remove');

// Route cho admin
$router->addRoute('GET', '/admin', 'AdminController@index');
$router->addRoute('GET', '/admin/foods', 'AdminController@index');
$router->addRoute('GET', '/admin/foods/add', 'AdminController@showAddFood');
$router->addRoute('POST', '/admin/foods/add', 'AdminController@addFood');
$router->addRoute('GET', '/admin/foods/edit/{id}', 'AdminController@showEditFood');
$router->addRoute('POST', '/admin/foods/edit/{id}', 'AdminController@editFood');
$router->addRoute('POST', '/admin/foods/delete/{id}', 'AdminController@deleteFood');

// Route cho favorites
$router->addRoute('POST', '/favorites/toggle/{id}', 'FavoriteController@toggle');

// Route cho menus
$router->addRoute('POST', '/menus/delete/{id}', 'MenuController@delete');
$router->addRoute('POST', '/menus/add-food/{menuId}', 'MenuController@addFoodToMenu'); 
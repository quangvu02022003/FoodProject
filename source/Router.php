<?php
namespace App;

class Router {
    private $routes = [];

    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function match($requestUri) {
        $requestUri = str_replace('/index.php', '', $requestUri);
        
        if (empty($requestUri)) {
            $requestUri = '/';
        }
        
        foreach ($this->routes as $route) {
            $pattern = $this->convertPathToRegex($route['path']);
            
            if ($_SERVER['REQUEST_METHOD'] === $route['method'] && preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches);
                
                $handler = explode('@', $route['handler']);
                $controllerName = "App\\Controller\\" . $handler[0];
                $methodName = $handler[1];
                
                $controller = new $controllerName();
                return call_user_func_array([$controller, $methodName], $matches);
            }
        }
        
        http_response_code(404);
        require 'views/404.php';
    }

    private function convertPathToRegex($path) {
        $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '([^/]+)', $path);
        return "#^" . $pattern . "$#";
    }
} 
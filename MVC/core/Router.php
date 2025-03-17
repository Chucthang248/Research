<?php
namespace Core;

use Core\Request;
use Core\Response;

class Router {
    private $routes = [];
    private $middlewares = [];

    public function get($path, $controller, $method, $middlewares = []) {
        $this->addRoute('GET', $path, $controller, $method, $middlewares);
    }

    public function post($path, $controller, $method, $middlewares = []) {
        $this->addRoute('POST', $path, $controller, $method, $middlewares);
    }

    public function put($path, $controller, $method, $middlewares = []) {
        $this->addRoute('PUT', $path, $controller, $method, $middlewares);
    }

    public function delete($path, $controller, $method, $middlewares = []) {
        $this->addRoute('DELETE', $path, $controller, $method, $middlewares);
    }

    private function addRoute($httpMethod, $path, $controller, $method, $middlewares) {
        $route = [
            'method' => $httpMethod,
            'path' => $path,
            'controller' => $controller,
            'action' => $method,
            'middlewares' => $middlewares
        ];
        
        $this->routes[] = $route;
    }

    public function addMiddleware($middleware) {
        $this->middlewares[] = $middleware;
    }

    public function dispatch($url, $method) {
        $url = rtrim($url, '/');
        $url = $url ?: '/';
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            
            $pattern = $this->convertRouteToRegex($route['path']);
            
            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches); // Remove the full match
                
                $controller = $route['controller'];
                $action = $route['action'];
                
                // Create request
                $request = new Request();
                
                // Apply global middlewares
                foreach ($this->middlewares as $middleware) {
                    $instance = new $middleware();
                    if (!$instance->handle($request)) {
                        return;
                    }
                }
                
                // Apply route middlewares
                foreach ($route['middlewares'] as $middleware) {
                    $instance = new $middleware();
                    if (!$instance->handle($request)) {
                        return;
                    }
                }
                
                $controllerInstance = new $controller();
                $controllerInstance->$action($request, ...$matches);
                return;
            }
        }
        
        // No route matched
        Response::error('Not found', 404);
    }

    private function convertRouteToRegex($route) {
        $pattern = preg_replace('/\/{([\w-]+)}/', '/([^/]+)', $route);
        return "#^{$pattern}$#i";
    }
}

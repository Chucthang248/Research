<?php
// Entry point for the application

// Define base path
define('BASE_PATH', __DIR__);

// Include config file
require_once BASE_PATH . '/config/database.php';

// Get the URL segments
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim($uri, '/'));

// Default controller and action
$controllerName = !empty($uri[0]) ? ucfirst($uri[0]) . 'Controller' : 'HomeController';
$actionName = isset($uri[1]) ? $uri[1] : 'index';

// Load controller
$controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Instantiate controller
    $controller = new $controllerName();
    
    // Call the action if it exists
    if (method_exists($controller, $actionName)) {
        $controller->$actionName();
    } else {
        // Action not found
        header("HTTP/1.0 404 Not Found");
        echo "Action not found!";
    }
} else {
    // Controller not found
    header("HTTP/1.0 404 Not Found");
    echo "Controller not found!";
}

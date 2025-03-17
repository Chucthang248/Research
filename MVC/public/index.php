<?php
// Try to load Composer's autoloader
$composerAutoload = '../vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
} else {
    // Fallback custom autoloader
    require_once '../core/Autoloader.php';
    $autoloader = new Core\Autoloader();
    $autoloader->register();
}

use Core\Router;
use App\Middleware\CorsMiddleware;
use App\Middleware\AuthMiddleware;
use App\Controllers\AuthController;
use App\Controllers\UserController;

// Serve API docs - updated to handle exact path match without redirection
if ($_SERVER['REQUEST_URI'] === '/api-docs' || $_SERVER['REQUEST_URI'] === '/api-docs/') {
    include 'index.html';
    exit;
}

// Setup router
$router = new Router();

// Apply global middlewares
$router->addMiddleware(CorsMiddleware::class);

// Define routes
$router->post('/auth/register', AuthController::class, 'register');
$router->post('/auth/login', AuthController::class, 'login');
$router->get('/auth/profile', AuthController::class, 'profile', [AuthMiddleware::class]);

$router->get('/users', UserController::class, 'index', [AuthMiddleware::class]);
$router->get('/users/{id}', UserController::class, 'show', [AuthMiddleware::class]);
$router->put('/users/{id}', UserController::class, 'update', [AuthMiddleware::class]);
$router->delete('/users/{id}', UserController::class, 'destroy', [AuthMiddleware::class]);

// Dispatch request
$url = isset($_GET['url']) ? $_GET['url'] : '/';
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($url, $method);

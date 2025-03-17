<?php
namespace App\Middleware;

use App\Middleware\Middleware;
use Core\Request;

class CorsMiddleware extends Middleware {
    public function handle(Request $request) {
        $config = require_once '../config/config.php';
        $corsConfig = $config['cors'];
        
        // Access-Control-Allow-Origin
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        if (in_array('*', $corsConfig['allowed_origins']) || in_array($origin, $corsConfig['allowed_origins'])) {
            header("Access-Control-Allow-Origin: {$origin}");
        }
        
        // Access-Control-Allow-Methods
        $allowedMethods = implode(', ', $corsConfig['allowed_methods']);
        header("Access-Control-Allow-Methods: {$allowedMethods}");
        
        // Access-Control-Allow-Headers
        $allowedHeaders = implode(', ', $corsConfig['allowed_headers']);
        header("Access-Control-Allow-Headers: {$allowedHeaders}");
        
        // Access-Control-Max-Age
        header('Access-Control-Max-Age: 86400'); // 24 hours
        
        // Handle preflight OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 204 No Content');
            exit;
        }
        
        return $this->next($request);
    }
}

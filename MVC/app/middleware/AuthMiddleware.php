<?php
namespace App\Middleware;

use App\Middleware\Middleware;
use Core\Request;
use Core\Response;
use Core\JWT;

class AuthMiddleware extends Middleware {
    public function handle(Request $request) {
        $token = $request->getAuthorizationToken();
        if (!$token) {
            Response::error('Unauthorized: No token provided', 401);
            return false;
        }
        
        $jwt = new JWT();
        $userData = $jwt->validateToken($token);
        if (!$userData) {
            Response::error('Unauthorized: Invalid token', 401);
            return false;
        }
        
        // Add user to request
        $request->user = $userData;
        
        return $this->next($request);
    }
}

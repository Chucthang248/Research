<?php
namespace Core;

class Request {
    private $body;
    private $params;
    private $method;
    private $headers;
    public $user;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = $this->getHeaders();
        $this->body = $this->parseBody();
    }
    
    private function getHeaders() {
        $headers = [];
        foreach($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))))] = $value;
            }
        }
        return $headers;
    }
    
    private function parseBody() {
        if ($this->method === 'GET') {
            return;
        }
        
        $body = file_get_contents('php://input');
        $content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
        
        if (strpos($content_type, 'application/json') !== false) {
            $body = json_decode($body, true);
        }
        
        return $body;
    }
    
    public function getMethod() {
        return $this->method;
    }
    
    public function getBody() {
        return $this->body;
    }
    
    public function getHeader($name) {
        return isset($this->headers[$name]) ? $this->headers[$name] : null;
    }
    
    public function getAuthorizationToken() {
        $header = $this->getHeader('Authorization');
        if ($header && strpos($header, 'Bearer ') === 0) {
            return substr($header, 7);
        }
        return null;
    }
    
    public function validate($rules) {
        $errors = [];
        foreach($rules as $field => $rule) {
            if (strpos($rule, 'required') !== false && (!isset($this->body[$field]) || empty($this->body[$field]))) {
                $errors[$field] = "$field is required";
            }
            
            if (isset($this->body[$field])) {
                if (strpos($rule, 'email') !== false && !filter_var($this->body[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = "$field must be a valid email";
                }
                
                if (strpos($rule, 'min:') !== false) {
                    preg_match('/min:(\d+)/', $rule, $matches);
                    $min = (int)$matches[1];
                    if (strlen($this->body[$field]) < $min) {
                        $errors[$field] = "$field must be at least $min characters";
                    }
                }
            }
        }
        
        return $errors;
    }
}

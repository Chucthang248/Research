<?php
namespace App\Middleware;

use Core\Request;

abstract class Middleware {
    protected $next;
    
    public function __construct($next = null) {
        $this->next = $next;
    }
    
    abstract public function handle(Request $request);
    
    public function next(Request $request) {
        if ($this->next) {
            return $this->next->handle($request);
        }
        return true;
    }
}

<?php
namespace Core;

class Autoloader {
    public function register() {
        spl_autoload_register([$this, 'autoload']);
    }
    
    private function autoload($class) {
        // Convert namespace separators to directory separators
        $file = str_replace('\\', '/', $class) . '.php';
        
        // PSR-4: App\Controllers\HomeController -> app/controllers/HomeController.php
        // Core\Router -> core/Router.php
        $file = str_replace(['App/', 'Core/'], ['app/', 'core/'], $file);
        
        // First check if the file exists in the project root
        if (file_exists('../' . $file)) {
            require_once '../' . $file;
            return true;
        }
        
        return false;
    }
}

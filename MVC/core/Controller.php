<?php
namespace Core;

class Controller {
    public function model($model) {
        $modelClass = 'App\\Models\\' . $model;
        
        // Check if we need to manually include the file (when autoloader fails)
        $modelFile = '../app/models/' . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
        }
        
        return new $modelClass();
    }

    public function view($view, $data = []) {
        require_once '../app/views/' . $view . '.php';
    }
}

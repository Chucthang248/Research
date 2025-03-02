<?php 
require_once 'Cache.php';

class FileCache implements Cache {
    
    public function __construct(){}

    public function set($key, $value) {
        // code here
    }

    public function get($key) {
        echo "Files get: " . $key;
    }
        
}
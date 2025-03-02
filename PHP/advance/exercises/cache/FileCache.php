<?php 
require_once 'CacheProcess.php';

class FileCache extends CacheProcess {
    
    public function __construct(){}

    public function set($key, $value) {
        // code here
    }

    public function get($key) {
        echo "Files get: " . $key;
    }
        
}
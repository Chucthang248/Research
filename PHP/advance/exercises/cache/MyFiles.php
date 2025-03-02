<?php 
require_once 'CacheProcess.php';

class MyFiles extends CacheProcess {
    
    public function __construct(){}

    public function set($key, $value) {
        // code here
    }

    public function get($key) {
        echo "Files get: " . $key;
    }
        
}
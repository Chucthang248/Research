<?php 
require_once 'Cache.php';

class MemcachedCache implements  Cache {

    public function __construct(){}

    public function set($key, $value) {
        // code here
    }

    public function get($key) {
        echo "Memcached get: " . $key;
    }
        
}
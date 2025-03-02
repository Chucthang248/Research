<?php 
require_once 'CacheProcess.php';

class MemcachedCache extends CacheProcess {

    public function __construct(){}

    public function set($key, $value) {
        // code here
    }

    public function get($key) {
        echo "Memcached get: " . $key;
    }
        
}
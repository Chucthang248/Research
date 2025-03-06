<?php 
 require_once 'CacheFactory.php';

 class Cache {
    protected $cacheFactory;

    public function __construct()
    {
        $this->cacheFactory = CacheFactory::make();
    }

    public function set($key, $value) {
          $this->cacheFactory->set($key, $value);
    }

    public function get($key) {
     $this->cacheFactory->get($key);
    }
}

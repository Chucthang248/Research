<?php 
 require_once 'FileCache.php';
 require_once 'MemcachedCache.php';

 class CacheFactory {
    protected $instance;

    public function __construct() {
        
        $drivers = [
            'Files' => FileCache::class,
            'Memcached' => MemcachedCache::class
        ];

        if (!isset($drivers[getenv('CACHE')])) {
            throw new Exception("Cache driver không hợp lệ: " . getenv('CACHE'));
        }

        $cacheType = getenv('CACHE') ?: 'Memcached';
        $this->instance = new $drivers[$cacheType]();
    }

    public function set($key, $value) {
        return $this->instance->set($key, $value);
    }

    public function get($key) {
        return $this->instance->get($key);
    }
}

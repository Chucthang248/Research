<?php 
 require_once 'MyFiles.php';
 require_once 'MyMemcached.php';

 class MyCache {
    protected $instance;

    public function __construct() {
        
        $drivers = [
            'Files' => MyFiles::class,
            'Memcached' => MyMemcached::class
        ];

        if (!isset($drivers[getenv('CACHE')])) {
            throw new Exception("Cache driver không hợp lệ: " . getenv('CACHE'));
        }

        $cacheType = getenv('CACHE') ?: 'Memcached'; // Mặc định là Memcached
        $this->instance = new $drivers[$cacheType](); // Khởi tạo đúng class
    }

    public function set($key, $value) {
        return $this->instance->set($key, $value); // ✅ Ủy quyền
    }

    public function get($key) {
        return $this->instance->get($key); // ✅ Ủy quyền
    }
}

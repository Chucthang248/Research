<?php 
 require_once 'FileCache.php';
 require_once 'MemcachedCache.php';

 class CacheFactory {
    protected $instance;

    public static function make() {

        switch (getenv('CACHE')) {
            case 'cloud':
                return new FileCache();
            case 'file':
                return new MemcachedCache();
            default:
                throw new Exception("Cache driver không hợp lệ");
        }
    }
}

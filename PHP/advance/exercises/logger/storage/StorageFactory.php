<?php

use function PHPUnit\Framework\throwException;

 require_once 'CloudStorage.php';
 require_once 'FileStorage.php';

 class StorageFactory {
    public static function make($config = null) {
        switch (getenv('LOG_SYSTEM')) {
            case 'cloud':
                return new CloudStorage($config);
            case 'file':
                return new FileStorage($config);
            default:
                throw new Exception("LOG_SYSTEM chưa được cài đặt");
        }
    }
}

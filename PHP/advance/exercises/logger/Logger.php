<?php 
 require_once 'LogLevel.php';
 require_once './storage/StorageFactory.php';

 class Logger implements LogLevel{
    protected $storage;

    public function __construct($path, $config)
    {
        $this->storage = StorageFactory::make($config);
    }

    public function debug($content) {
        $this->storage->write($content, 'debug');
    }

    public function info($content) {
        $this->storage->write($content, 'info');
    }

    public function warn($content) {
        $this->storage->write($content, 'warn');
    }

    public function error($content) {
        $this->storage->write($content, 'error');
    }


}

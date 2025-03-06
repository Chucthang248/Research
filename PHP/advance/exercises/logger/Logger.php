<?php 
 require_once 'LogLevel.php';
 require_once __DIR__ . '/storage/StorageFactory.php';

 class Logger implements LogLevel{
    protected $storage;

    public function __construct($config)
    {
        $this->storage = StorageFactory::make($config);
    }

    protected function log($content, $level) {
        $this->storage->write($content, $level);

    }

    public function debug($content) {
        $this->log($content, 'debug');
    }

    public function info($content) {
        $this->log($content, 'info');
    }

    public function warn($content) {
        $this->log($content, 'warn');
    }

    public function error($content) {
        $this->log($content, 'error');
    }


}

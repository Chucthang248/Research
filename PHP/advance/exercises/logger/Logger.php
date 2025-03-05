<?php 
 require_once 'LogLevel.php';
 require_once './storage/StorageFactory.php';

 class Logger implements LogLevel{
    protected $storage;

    public function __construct($path, $config)
    {
        $this->storage = StorageFactory::make($config);
    }

    protected function log($level, $content) {
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

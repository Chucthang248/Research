<?php 

abstract class CacheProcess {
    abstract public function set($key, $value);
    abstract public function get($key);
}
<?php 

interface Cache {
     public function set($key, $value);
     public function get($key);
}
<?php
spl_autoload_register(function ($class) {
    require_once $class . '.php';
});

$caching = new CacheFactory();
$caching->get('test_key');
?>
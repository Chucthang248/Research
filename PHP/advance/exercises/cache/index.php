<?php
spl_autoload_register(function ($class) {
    require_once $class . '.php';
});

$caching = new Cache();
$caching->get('test_key');
?>
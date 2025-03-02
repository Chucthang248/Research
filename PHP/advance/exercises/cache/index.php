<?php
spl_autoload_register(function ($class) {
    require_once $class . '.php';
});

$caching = new MyCache();
$caching->get('test_key'); // ✅ Gọi đúng đối tượng
?>
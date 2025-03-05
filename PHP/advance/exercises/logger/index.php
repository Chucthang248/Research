<?php
spl_autoload_register(function ($class) {
    require_once $class . '.php';
});

$log = new Logger('/path/folder1/', 'test');
$log->debug('ok');
?>
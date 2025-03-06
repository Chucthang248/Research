<?php
spl_autoload_register(function ($class) {
    require_once $class . '.php';
});

echo getenv('LOG_SYSTEM');
$log = new Logger([
    'fileName' => 'test'
]);
$log->debug('ok');

$log = new Logger([
    'fileName' => 'test'
]);
$log->warn('ok');
?>
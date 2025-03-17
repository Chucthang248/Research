<?php
return [
    'database' => [
        'host' => 'localhost',
        'name' => 'mvc_auth',
        'user' => 'root',
        'password' => '',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ],
    'jwt' => [
        'secret' => 'your_strong_secret_key',
        'expiration' => 3600, // 1 hour
        'issuer' => 'mvc_api'
    ],
    'cors' => [
        'allowed_origins' => ['*'],
        'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
        'allowed_headers' => ['Content-Type', 'Authorization']
    ]
];

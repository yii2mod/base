<?php

$config = [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=;dbname=',
            'username' => '',
            'password' => '',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'redis' => [
            'hostname' => 'redis',
        ],
    ],
];

return $config;

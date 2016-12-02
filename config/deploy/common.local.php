<?php

$config = [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=;dbname=',
            'username' => '',
            'password' => '',
        ],
        'mailer' => [
            'useFileTransport' => true
        ],
    ],
    'params' => [
    ],
];

return $config;

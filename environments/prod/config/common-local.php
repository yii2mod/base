<?php

$config = [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=;dbname=',
            'username' => '',
            'password' => '',
            'enableSchemaCache' => true,
        ],
        'redis' => [
            'hostname' => 'redis',
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
        'authManager' => [
            'cache' => 'cache',
        ],
    ],
];

return $config;

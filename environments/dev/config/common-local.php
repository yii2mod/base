<?php

$config = [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=;dbname=',
            'username' => '',
            'password' => '',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
    ],
];

return $config;

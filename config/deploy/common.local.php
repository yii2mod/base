<?php
$config = [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=;dbname=',
            'username' => '',
            'password' => '',
        ],
        'mailer' => [
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'localhost',
            ],
        ],
    ],
    'params' => [
    ]
];

return $config;

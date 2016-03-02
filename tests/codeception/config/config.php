<?php
/**
 * Application configuration shared by all test types
 */
return [
    'components' => [
        /*'db' => [
            'dsn' => 'mysql:host=localhost;dbname=yii2base',
            'username' => 'root',
            'password' => '',
        ],*/
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];

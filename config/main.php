<?php
$config = [
    'id' => 'main',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => '/',
    'modules' => [
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '',
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            'sessionTable' => 'Session',
        ],
        'user' => [
            'identityClass' => 'app\models\UserModel',
            'enableAutoLogin' => true,
            'loginUrl' => '/user/login',
        ],
        'errorHandler' => [
            'errorAction' => '/site/error',
        ],
        'urlManager' => [
            'cache' => false,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ]
        ],
    ],
    'params' => [
        'adminEmail' => 'admin@mail.com',
        'defaultPageSize' => 20,
        'pageSizeArray' => [
            10 => '10 items',
            20 => '20 items',
            50 => '50 items',
        ],
    ],
];

return $config;

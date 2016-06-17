<?php

$config = [
    'name' => 'Yii2 Basic Template',
    'language' => 'en-US',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest', 'user'],
            'itemTable' => '{{%AuthItem}}',
            'itemChildTable' => '{{%AuthItemChild}}',
            'assignmentTable' => '{{%AuthAssignment}}',
            'ruleTable' => '{{%AuthRule}}',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
        ],
        'cache' => [
            'class' => 'yii\caching\ArrayCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer'
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource'
                ],
            ],
        ],
    ],
    'params' => [
        'adminEmail' => 'admin@example.com',
        'user.passwordResetTokenExpire' => 3600,
    ],
];

return $config;

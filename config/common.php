<?php
$config = [
    'language' => 'en-US',
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
            'dsn' => 'mysql:host=;dbname=',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
              'class' => 'Swift_SmtpTransport',
              'host' => 'host-here',
          ],
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

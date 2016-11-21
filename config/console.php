<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests/codeception');

$config = [
    'id' => 'console',
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'migrate' => [
            'class' => 'cyberz\migrations\controllers\MigrationsController',
            'templateFile' => '@app/views/migration.php',
            'migrationLookup' => [
                '@vendor/yii2mod/yii2-cms/migrations',
                '@vendor/yii2mod/yii2-cron-log/migrations',
                '@vendor/yii2mod/yii2-user/migrations',
                '@vendor/yii2mod/yii2-comments/migrations',
                '@vendor/yii2mod/yii2-settings/migrations',
                '@yii/rbac/migrations',
            ],
        ],
    ],
    'components' => [
        'errorHandler' => [
            'class' => 'yii2mod\cron\components\ErrorHandler',
        ],
        'mutex' => [
            'class' => 'yii\mutex\FileMutex',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => 'http://localhost',
        ],
    ],
    'modules' => [
        'rbac' => [
            'class' => 'yii2mod\rbac\ConsoleModule',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

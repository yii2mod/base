<?php

$config = [
    'id' => 'main',
    'defaultRoute' => 'site/index',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'controllerMap' => [
                'cms' => 'yii2mod\cms\controllers\CmsController',
                'comments' => 'yii2mod\comments\controllers\ManageController',
            ],
            'modules' => [
                'rbac' => [
                    'class' => 'yii2mod\rbac\Module',
                ],
                'settings-storage' => [
                    'class' => 'yii2mod\settings\Module',
                ],
            ],
        ],
        'comment' => [
            'class' => 'yii2mod\comments\Module',
        ],
    ],
    'components' => [
        'settings' => [
            'class' => 'yii2mod\settings\components\Settings',
        ],
        'request' => [
            'cookieValidationKey' => 'fYPq2eLM',
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
        ],
        'user' => [
            'identityClass' => 'app\models\UserModel',
            'enableAutoLogin' => true,
            'on afterLogin' => function ($event) {
                $event->identity->updateLastLogin();
            },
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                ['class' => 'yii2mod\cms\components\PageUrlRule'],
            ],
        ],
    ],
];

return $config;

<?php

$config = [
    'id' => 'main',
    'defaultRoute' => 'site/index',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'modules' => [
                'rbac' => [
                    'class' => 'yii2mod\rbac\Module',
                    'controllerMap' => [
                        'route' => [
                            'class' => 'yii2mod\rbac\controllers\RouteController',
                            'modelClass' => [
                                'class' => 'yii2mod\rbac\models\RouteModel',
                                'excludeModules' => ['debug', 'gii'],
                            ],
                        ],
                    ],
                ],
                'settings-storage' => [
                    'class' => 'yii2mod\settings\Module',
                ],
            ],
        ],
        'comment' => [
            'class' => 'yii2mod\comments\Module',
            'controllerMap' => [
                'manage' => [
                    'class' => 'yii2mod\comments\controllers\ManageController',
                    'layout' => '@app/modules/admin/views/layouts/column2',
                ],
            ],
        ],
        'cms' => [
            'class' => 'yii2mod\cms\Module',
            'controllerMap' => [
                'manage' => [
                    'class' => 'yii2mod\cms\controllers\ManageController',
                    'layout' => '@app/modules/admin/views/layouts/column2',
                ],
            ],
        ],
    ],
    'components' => [
        'settings' => [
            'class' => 'yii2mod\settings\components\Settings',
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

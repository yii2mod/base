<?php
$config = [
    'id' => 'main',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'site/index',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'controllerMap' => [
                'cms' => 'yii2mod\cms\controllers\CmsController',
                'comments' => 'yii2mod\comments\controllers\ManageController'
            ],
            'modules' => [
                'rbac' => [
                    'class' => 'yii2mod\rbac\Module',
                ],
                'settings-storage' => [
                    'class' => 'yii2mod\settings\Module',
                ],
            ]
        ],
        'comment' => [
            'class' => 'yii2mod\comments\Module'
        ]
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
            'sessionTable' => '{{%Session}}',
        ],
        'user' => [
            'identityClass' => 'app\models\UserModel',
            'enableAutoLogin' => true,
            'loginUrl' => '/site/login',
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
                ['class' => 'yii2mod\cms\components\PageUrlRule'],
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

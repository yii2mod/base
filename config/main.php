<?php
$config = [
    'id' => 'main',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'site/index',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'controllerMap' => [
                'cms' => 'yii2mod\cms\controllers\CmsController'
            ],
            'modules' => [
                'rbac' => [
                    'class' => 'yii2mod\rbac\Module',
                ],
            ]
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
    ],
    'components' => [
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

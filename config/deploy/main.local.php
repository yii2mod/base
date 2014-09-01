<?php

$config = [
    'bootstrap' => [
        'debug',
        'gii'
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['10.8.4.*']
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['10.8.4.*'],
            'generators' => [
                'enumerable' => [
                    'class' => 'yii2mod\enum\giiTemplate\Generator',
                ]
            ],
        ],

    ],
    'components' => [
    ],
];

return $config;

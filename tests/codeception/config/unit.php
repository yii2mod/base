<?php
/**
 * Application configuration for unit tests
 */
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../config/main.php'),
    require(__DIR__ . '/../../../config/main.local.php'),
    require(__DIR__ . '/../../../config/common.php'),
    require(__DIR__ . '/../../../config/common.local.php'),
    require(__DIR__ . '/config.php'),
    [
        /*'components' => [
            'db' => [
                'dsn' => 'mysql:host=localhost;dbname=yii2_basic_unit',
            ],
        ],*/
    ]
);

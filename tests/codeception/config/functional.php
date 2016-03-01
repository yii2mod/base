<?php
$_SERVER['SCRIPT_FILENAME'] = YII_TEST_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = YII_TEST_ENTRY_URL;

/**
 * Application configuration for functional tests
 */
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../config/main.php'),
    require(__DIR__ . '/../../../config/main.local.php'),
    require(__DIR__ . '/../../../config/common.php'),
    require(__DIR__ . '/../../../config/common.local.php'),
    require(__DIR__ . '/config.php'),
    [
        'components' => [
            /*'db' => [
                'dsn' => 'mysql:host=localhost;dbname=yii2_basic_functional',
            ],*/
            'request' => [
                // it's not recommended to run functional tests with CSRF validation enabled
                'enableCsrfValidation' => false,
                // but if you absolutely need it set cookie domain to localhost
                /*
                'csrfCookie' => [
                    'domain' => 'localhost',
                ],
                */
            ],
        ],
    ]
);

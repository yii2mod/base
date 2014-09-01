<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

defined('YII_TEST_ENTRY_URL') or define('YII_TEST_ENTRY_URL', \Codeception\Configuration::config()['config']['test_entry_url']);
defined('YII_TEST_ENTRY_FILE') or define('YII_TEST_ENTRY_FILE', dirname(dirname(__DIR__)) . '/index-test.php');


$loader = require(__DIR__ . '/../../vendor/autoload.php');
$loader->addPsr4('yii2mod\\', __DIR__ . "/../vendor/yii2mod");
$loader->addPsr4('yii2mod\\user\\', __DIR__ . "/../vendor/yii2mod/user");
$loader->addPsr4('yii2mod\\rbac\\', __DIR__ . "/../vendor/yii2mod/rbac");
$loader->addPsr4('yii2mod\\set\\', __DIR__ . "/../vendor/yii2mod/set");
$loader->addPsr4('yii2mod\\behaviors\\', __DIR__ . "/../vendor/yii2mod/behaviors");
$loader->addPsr4('yii2mod\\validators\\', __DIR__ . "/../vendor/yii2mod/validators");
$loader->addPsr4('yii2mod\\enum\\', __DIR__ . "/../vendor/yii2mod/enum");
$loader->addPsr4('yii2mod\\hg\\', __DIR__ . "/../vendor/yii2mod/hg");
$loader->addPsr4('yii2mod\\cron\\', __DIR__ . "/../vendor/yii2mod/cron");
$loader->addPsr4('yii2mod\\cms\\', __DIR__ . "/../vendor/yii2mod/cms");
$loader->addPsr4('yii2mod\\shop\\', __DIR__ . "/../vendor/yii2mod/shop");
$loader->addPsr4('yii2mod\\flash\\', __DIR__ . "/../vendor/yii2mod/flash");


require_once(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');

$_SERVER['SCRIPT_FILENAME'] = YII_TEST_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = YII_TEST_ENTRY_URL;
$_SERVER['SERVER_NAME'] = 'localhost';

Yii::setAlias('@codeception', __DIR__);

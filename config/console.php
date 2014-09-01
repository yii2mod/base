<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
Yii::setAlias('@webroot', dirname(__DIR__));

$config = [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\commands',
];
return $config;
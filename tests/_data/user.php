<?php

return [
    [
        'username' => 'admin',
        'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
        'password_hash' => Yii::$app->getSecurity()->generatePasswordHash(123123),
        'email' => 'admin@example.org',
        'status' => 1,
        'created_at' => time(),
        'updated_at' => time(),
    ],
    [
        'username' => 'test-user',
        'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
        'password_hash' => Yii::$app->getSecurity()->generatePasswordHash(123123),
        'email' => 'test-user@example.com',
        'status' => 1,
        'created_at' => time(),
        'updated_at' => time(),
    ],
];

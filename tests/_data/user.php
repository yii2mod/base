<?php

return [
    [
        'username' => 'admin',
        'authKey' => Yii::$app->getSecurity()->generateRandomString(),
        'passwordHash' => Yii::$app->getSecurity()->generatePasswordHash(123123),
        'email' => 'admin@example.org',
        'status' => 1,
        'createdAt' => time(),
        'updatedAt' => time(),
    ],
    [
        'username' => 'test-user',
        'authKey' => Yii::$app->getSecurity()->generateRandomString(),
        'passwordHash' => Yii::$app->getSecurity()->generatePasswordHash(123123),
        'email' => 'test-user@example.com',
        'status' => 1,
        'createdAt' => time(),
        'updatedAt' => time(),
    ],
];

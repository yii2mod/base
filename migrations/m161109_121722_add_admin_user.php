<?php

use app\components\Migration;

class m161109_121722_add_admin_user extends Migration
{
    public function up()
    {
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'authKey' => Yii::$app->getSecurity()->generateRandomString(),
            'passwordHash' => Yii::$app->getSecurity()->generatePasswordHash(123123),
            'email' => 'admin@example.org',
            'status' => 1,
            'createdAt' => time(),
            'updatedAt' => time(),
        ]);
    }

    public function down()
    {
        $this->delete('{{%user}}', ['email' => 'admin@example.org']);
    }
}
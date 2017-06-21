<?php

use yii2mod\rbac\migrations\Migration;
use yii2mod\rbac\rules\UserRule;

class m160722_085418_init extends Migration
{
    public function safeUp()
    {
        $this->createRule('user', UserRule::class);

        $this->createRole('admin', 'Admin has all available permissions.');
        $this->createRole('user', 'Authenticated user.', 'user');
    }

    public function safeDown()
    {
        $this->removeRule('user');

        $this->removeRole('admin');
        $this->removeRole('user');
    }
}

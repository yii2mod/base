<?php

use yii\db\Schema;
use yii\db\Migration;

class m140703_140753_init_session extends Migration
{
    public function up()
    {
        $this->createTable('Session', [
            'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => 'INTEGER',
            'data' => 'LONGBLOB'
        ]);
    }

    public function down()
    {
        $this->dropTable('Session');
    }
}

<?php

use app\components\Migration;

/**
 * Class m160805_074616_create_session_table
 */
class m160805_074616_create_session_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%session}}', [
            'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => 'INTEGER',
            'data' => 'LONGBLOB'
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%session}}');
    }
}
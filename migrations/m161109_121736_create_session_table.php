<?php

use app\components\Migration;

/**
 * Handles the creation of table `session`.
 */
class m161109_121736_create_session_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%session}}', [
            'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => 'INTEGER',
            'data' => 'LONGBLOB',
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%session}}');
    }
}

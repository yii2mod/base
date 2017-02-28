<?php

use yii\db\Migration;

/**
 * Handles the creation of table `session`.
 */
class m161109_121736_create_session_table extends Migration
{
    public function up()
    {
        switch ($this->db->driverName) {
            case 'mysql':
            case 'mariadb':
                $dataType = 'LONGBLOB';
                break;
            case 'pgsql':
                $dataType = 'BYTEA';
                break;
            default:
                $dataType = 'TEXT';
        }

        $this->createTable('{{%session}}', [
            'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => 'INTEGER',
            'data' => $dataType,
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%session}}');
    }
}

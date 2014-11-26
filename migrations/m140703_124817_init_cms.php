<?php

use yii\db\Schema;
use yii\db\Migration;

class m140703_124817_init_cms extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        return $this->createTable('Cms', [
            'id' => 'INT(11) PRIMARY KEY AUTO_INCREMENT',
            'url' => 'VARCHAR(255)',
            'title' => 'VARCHAR(255)',
            'content' => 'TEXT',
            'status' => 'TINYINT(2)',
            'metaTitle' => 'TEXT',
            'metaDescription' => 'TEXT',
            'metaKeywords' => 'TEXT',
            'dateCreated' => 'INT(11)',
            'dateUpdated' => 'INT(11)',
        ], $tableOptions);
    }

    public function down()
    {
        return $this->dropTable('Cms');
    }

}

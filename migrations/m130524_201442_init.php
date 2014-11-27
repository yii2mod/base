<?php
use yii\db\Schema;
use yii\db\Migration;

/**
 * Init migrations
 * Class m130524_201442_init
 * @author Igor Chepurnoy
 */
class m130524_201442_init extends Migration
{
    /**
     * Up
     * @return bool|void
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        //Create user table
        $this->createTable('{{%User}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'authKey' => Schema::TYPE_STRING . '(32) NOT NULL',
            'passwordHash' => Schema::TYPE_STRING . ' NOT NULL',
            'passwordResetToken' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        //Create user details table
        $this->createTable('UserDetails', [
            'userId' => Schema::TYPE_PK,
            'FOREIGN KEY (userId) REFERENCES {{%User}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        //Create Cms table
        $this->createTable('Cms', [
            'id' => Schema::TYPE_PK,
            'url' => Schema::TYPE_STRING . '(255)',
            'title' => Schema::TYPE_STRING . '(255)',
            'content' => Schema::TYPE_TEXT,
            'status' => Schema::TYPE_SMALLINT,
            'metaTitle' => Schema::TYPE_TEXT,
            'metaDescription' => Schema::TYPE_TEXT,
            'metaKeywords' => Schema::TYPE_TEXT,
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        //Insert pages in CMS table
        $this->insert('Cms', [
            'url' => 'about-us',
            'title' => 'About us',
            'content' => 'About us content',
            'status' => 1,
            'metaTitle' => 'About us',
            'metaDescription' => 'About us description',
            'metaKeywords' => 'About us keywords',
            'createdAt' => time(),
            'updatedAt' => time(),
        ]);

        $this->insert('Cms', [
            'url' => 'terms-and-conditions',
            'title' => 'Terms & Conditions',
            'content' => 'Content',
            'status' => 1,
            'metaTitle' => 'Terms & Conditions',
            'metaDescription' => 'Terms & Conditions description',
            'metaKeywords' => 'Terms & Conditions keywords',
            'createdAt' => time(),
            'updatedAt' => time(),
        ]);

        $this->insert('Cms', [
            'url' => 'privacy-policy',
            'title' => 'Privacy Policy',
            'content' => 'Content',
            'status' => 1,
            'metaTitle' => 'Privacy Policy',
            'metaDescription' => 'Privacy Policy description',
            'metaKeywords' => 'Privacy Policy keywords',
            'createdAt' => time(),
            'updatedAt' => time(),
        ]);

        //Create Session table
        $this->createTable('Session', [
            'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => 'INTEGER',
            'data' => 'LONGBLOB'
        ]);

        //Create tables for RBAC module
        $this->createTable('AuthRule', [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'data' => Schema::TYPE_TEXT,
            'createdAt' => Schema::TYPE_INTEGER,
            'updatedAt' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (name)',
        ], $tableOptions);

        //Create auth item table
        $this->createTable('AuthItem', [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'ruleName' => Schema::TYPE_STRING . '(64)',
            'data' => Schema::TYPE_TEXT,
            'createdAt' => Schema::TYPE_INTEGER,
            'updatedAt' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (name)',
            'FOREIGN KEY (ruleName) REFERENCES AuthRule (name) ON DELETE SET NULL ON UPDATE CASCADE',
        ], $tableOptions);
        $this->createIndex('idx-auth_item-type', 'AuthItem', 'type');

        //Create AuthAssignment table
        $this->createTable('AuthAssignment', [
            'itemName' => Schema::TYPE_STRING . '(64) NOT NULL',
            'userId' => Schema::TYPE_STRING . '(64) NOT NULL',
            'createdAt' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (itemName, userId)',
            'FOREIGN KEY (itemName) REFERENCES AuthItem (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        //Create AuthItemChild table
        $this->createTable('AuthItemChild', [
            'parent' => Schema::TYPE_STRING . '(64) NOT NULL',
            'child' => Schema::TYPE_STRING . '(64) NOT NULL',
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES AuthItem (name) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (child) REFERENCES AuthItem (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        // Create Cron Shedule table
        return $this->createTable('CronSchedule', [
            'id' => Schema::TYPE_PK,
            'jobCode' => Schema::TYPE_STRING . '(255)',
            'status' => Schema::TYPE_STRING . '(255)',
            'messages' => Schema::TYPE_TEXT,
            'status' => Schema::TYPE_SMALLINT,
            'dateCreated' => Schema::TYPE_TIMESTAMP,
            'dateScheduled' => Schema::TYPE_TIMESTAMP,
            'dateExecuted' => Schema::TYPE_TIMESTAMP,
            'dateFinished' => Schema::TYPE_TIMESTAMP,
        ], $tableOptions);

        $this->createIndex('IDX_CRON_SCHEDULE_JOB_CODE', 'CronSchedule', ['jobCode']);
        $this->createIndex('IDX_CRON_SCHEDULE_SCHEDULED_AT_STATUS', 'CronSchedule', ['dateScheduled', 'status']);
    }

    /**
     * Down
     * @return bool|void
     */
    public function down()
    {
        //Drop user & userDetails tables
        $this->dropTable('{{%User}}');
        $this->dropTable('UserDetails');
        //Drop cms table
        $this->dropTable('Cms');
        //Drop session table
        $this->dropTable('Session');
        //Drop auth tables
        $this->dropTable('AuthAssignment');
        $this->dropTable('AuthItemChild');
        $this->dropTable('AuthItem');
        $this->dropTable('AuthRule');
        //Drop cron table
        $this->dropTable('CronSchedule');
    }
}
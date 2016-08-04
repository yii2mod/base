<?php

use app\components\Migration;

/**
 * Class m130524_201442_init
 */
class m130524_201442_init extends Migration
{
    public function up()
    {
        // Create user table
        $this->createTable('{{%User}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'authKey' => $this->string(32)->notNull(),
            'passwordHash' => $this->string()->notNull(),
            'passwordResetToken' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull(),
            'lastLogin' => $this->integer()
        ], $this->tableOptions);

        // Create admin user
        $this->insert('{{%User}}', [
            'username' => 'admin',
            'authKey' => Yii::$app->getSecurity()->generateRandomString(),
            'passwordHash' => Yii::$app->getSecurity()->generatePasswordHash(123123),
            'email' => 'admin@mail.com',
            'status' => 1,
            'createdAt' => time(),
            'updatedAt' => time(),
        ]);

        // Create Cms table
        $this->createTable('{{%Cms}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'commentAvailable' => $this->smallInteger()->notNull()->defaultValue(0),
            'metaTitle' => $this->text()->notNull(),
            'metaDescription' => $this->text(),
            'metaKeywords' => $this->text(),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull()
        ], $this->tableOptions);

        // Create Comment table
        $this->createTable('{{%Comment}}', [
            'id' => $this->primaryKey(),
            'entity' => $this->char(10)->notNull(),
            'entityId' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'parentId' => $this->integer()->null(),
            'level' => $this->smallInteger()->notNull()->defaultValue(1),
            'createdBy' => $this->integer()->notNull(),
            'updatedBy' => $this->integer()->notNull(),
            'relatedTo' => $this->string(500)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull()
        ], $this->tableOptions);

        $this->createIndex('idx-Comment-entity', '{{%Comment}}', 'entity');
        $this->createIndex('idx-Comment-status', '{{%Comment}}', 'status');

        // Insert pages in CMS table
        $this->insert('{{%Cms}}', [
            'url' => 'about-us',
            'title' => 'About us',
            'content' => 'About us content',
            'metaTitle' => 'About us',
            'metaDescription' => 'About us description',
            'metaKeywords' => 'About us keywords',
            'createdAt' => time(),
            'updatedAt' => time(),
        ]);

        $this->insert('{{%Cms}}', [
            'url' => 'terms-and-conditions',
            'title' => 'Terms & Conditions',
            'content' => 'Content',
            'metaTitle' => 'Terms & Conditions',
            'metaDescription' => 'Terms & Conditions description',
            'metaKeywords' => 'Terms & Conditions keywords',
            'createdAt' => time(),
            'updatedAt' => time(),
        ]);

        $this->insert('{{%Cms}}', [
            'url' => 'privacy-policy',
            'title' => 'Privacy Policy',
            'content' => 'Content',
            'metaTitle' => 'Privacy Policy',
            'metaDescription' => 'Privacy Policy description',
            'metaKeywords' => 'Privacy Policy keywords',
            'createdAt' => time(),
            'updatedAt' => time(),
        ]);

        // Create Setting table
        $this->createTable('{{%Setting}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(10)->notNull(),
            'section' => $this->string()->notNull(),
            'key' => $this->string()->notNull(),
            'value' => $this->text()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull()
        ], $this->tableOptions);

        // Create Session table
        $this->createTable('{{%Session}}', [
            'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => 'INTEGER',
            'data' => 'LONGBLOB'
        ], $this->tableOptions);

        // Create CronSchedule table
        $this->createTable('{{%CronSchedule}}', [
            'id' => $this->primaryKey(),
            'jobCode' => $this->string()->null(),
            'status' => $this->smallInteger()->notNull(),
            'messages' => $this->text(),
            'dateCreated' => $this->timestamp()->null(),
            'dateScheduled' => $this->timestamp()->null(),
            'dateExecuted' => $this->timestamp()->null(),
            'dateFinished' => $this->timestamp()->null(),
        ], $this->tableOptions);

        $this->createIndex('idx-CronSchedule-jobCode', '{{%CronSchedule}}', ['jobCode']);
        $this->createIndex('idx-CronSchedule-dateScheduled-status', '{{%CronSchedule}}', ['dateScheduled', 'status']);
    }

    public function down()
    {
        $this->dropTable('{{%User}}');
        $this->dropTable('{{%Cms}}');
        $this->dropTable('{{%Comment}}');
        $this->dropTable('{{%Session}}');
        $this->dropTable('{{%CronSchedule}}');
        $this->dropTable('{{%Setting}}');
    }
}

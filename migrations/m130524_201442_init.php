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
            'username' => $this->string()->notNull(),
            'authKey' => $this->string(32)->notNull(),
            'passwordHash' => $this->string()->notNull(),
            'passwordResetToken' => $this->string(),
            'email' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull(),
            'lastLogin' => $this->integer()
        ], $this->tableOptions);

        // Create admin user
        $this->insert('{{%User}}', [
            'id' => 1,
            'username' => 'admin',
            'authKey' => '6OFUxxVvoz067LISkZBY0JmZ-30NJK5j',
            'passwordHash' => '$2y$13$BtICgI3WpoMuUe3/t4AXOuRQD6cx90mttQUfi7uYkC2nvGE8dh4Ve',
            'passwordResetToken' => 'FFFONvY8njNEkm16-czMKmoWSQtT9eoC_1417103710',
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
            'status' => $this->boolean()->notNull()->defaultValue(1),
            'commentAvailable' => $this->boolean()->notNull()->defaultValue(0),
            'metaTitle' => $this->text()->notNull(),
            'metaDescription' => $this->text(),
            'metaKeywords' => $this->text(),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull(),
        ], $this->tableOptions);

        // Create Comment table
        $this->createTable('{{%Comment}}', [
            'id' => $this->primaryKey(),
            'entity' => $this->char(10)->notNull(),
            'entityId' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'parentId' => $this->integer()->null(),
            'level' => $this->smallInteger()->notNull(),
            'createdBy' => $this->integer()->notNull(),
            'updatedBy' => $this->integer()->notNull(),
            'relatedTo' => $this->string(500)->notNull(),
            'status' => $this->boolean()->defaultValue(1),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull()
        ], $this->tableOptions);

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
            'status' => $this->boolean(),
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

        $this->createIndex('IDX_CRON_SCHEDULE_JOB_CODE', '{{%CronSchedule}}', ['jobCode']);
        $this->createIndex('IDX_CRON_SCHEDULE_SCHEDULED_AT_STATUS', '{{%CronSchedule}}', ['dateScheduled', 'status']);
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

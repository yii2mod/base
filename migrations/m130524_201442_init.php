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
            'lastLogin' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        //Create Cms table
        $this->createTable('{{%Cms}}', [
            'id' => Schema::TYPE_PK,
            'url' => Schema::TYPE_STRING . '(255)',
            'title' => Schema::TYPE_STRING . '(255)',
            'content' => Schema::TYPE_TEXT,
            'status' => Schema::TYPE_SMALLINT,
            'commentAvailable' => 'TINYINT(1) DEFAULT 0',
            'metaTitle' => Schema::TYPE_TEXT,
            'metaDescription' => Schema::TYPE_TEXT,
            'metaKeywords' => Schema::TYPE_TEXT,
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        //Create Comment table
        $this->createTable('{{%Comment}}', [
            'id' => Schema::TYPE_PK,
            'entity' => 'CHAR(10) NOT NULL',
            'entityId' => Schema::TYPE_INTEGER . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'parentId' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'level' => 'TINYINT(3) NOT NULL DEFAULT 1',
            'createdBy' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedBy' => Schema::TYPE_INTEGER . ' NOT NULL',
            'relatedTo' => $this->string(500)->notNull(),
            'status' => 'TINYINT(2) NOT NULL DEFAULT 1',
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        //Insert pages in CMS table
        $this->insert('{{%Cms}}', [
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

        $this->createTable('{{%Setting}}', [
            'id' => Schema::TYPE_PK,
            'type' => Schema::TYPE_STRING . '(10) NOT NULL',
            'section' => Schema::TYPE_STRING . ' NOT NULL',
            'key' => Schema::TYPE_STRING . ' NOT NULL',
            'value' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->insert('{{%Cms}}', [
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

        $this->insert('{{%Cms}}', [
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
        $this->createTable('{{%Session}}', [
            'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => 'INTEGER',
            'data' => 'LONGBLOB'
        ], $tableOptions);

        $this->createTable('{{%AuthRule}}', [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (name)',
        ], $tableOptions);

        $this->createTable('{{%AuthItem}}', [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'rule_name' => Schema::TYPE_STRING . '(64)',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (name)',
            'FOREIGN KEY (rule_name) REFERENCES ' . '{{%AuthRule}}' . ' (name) ON DELETE SET NULL ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createIndex('idx-auth_item-type', '{{%AuthItem}}', 'type');

        $this->createTable('{{%AuthItemChild}}', [
            'parent' => Schema::TYPE_STRING . '(64) NOT NULL',
            'child' => Schema::TYPE_STRING . '(64) NOT NULL',
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES ' . '{{%AuthItem}}' . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (child) REFERENCES ' . '{{%AuthItem}}' . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%AuthAssignment}}', [
            'item_name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY (item_name) REFERENCES ' . '{{%AuthItem}}' . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        // Create Cron Shedule table
        $this->createTable('{{%CronSchedule}}', [
            'id' => Schema::TYPE_PK,
            'jobCode' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'messages' => Schema::TYPE_TEXT . ' NULL',
            'dateCreated' => Schema::TYPE_TIMESTAMP . ' NULL DEFAULT NULL',
            'dateScheduled' => Schema::TYPE_TIMESTAMP . ' NULL DEFAULT NULL',
            'dateExecuted' => Schema::TYPE_TIMESTAMP . ' NULL DEFAULT NULL',
            'dateFinished' => Schema::TYPE_TIMESTAMP . ' NULL DEFAULT NULL',
        ], $tableOptions);

        $this->createIndex('IDX_CRON_SCHEDULE_JOB_CODE', '{{%CronSchedule}}', ['jobCode']);
        $this->createIndex('IDX_CRON_SCHEDULE_SCHEDULED_AT_STATUS', '{{%CronSchedule}}', ['dateScheduled', 'status']);

        //Insert admin user
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

        $this->execute('SET FOREIGN_KEY_CHECKS=0;');
        //Insert auth assignment
        $this->insert('{{%AuthAssignment}}', [
            'item_name' => 'admin',
            'user_id' => 1,
            'created_at' => time(),
        ]);
        //insert auth item
        $this->batchInsert('{{%AuthItem}}', ['name', 'type', 'description', 'rule_name', 'data', 'created_at', 'updated_at'], [
            ['/admin/*', 2, NULL, NULL, NULL, time(), time()],
            ['/site/captcha', 2, NULL, NULL, NULL, time(), time()],
            ['/site/contact', 2, NULL, NULL, NULL, time(), time()],
            ['/site/error', 2, NULL, NULL, NULL, time(), time()],
            ['/site/index', 2, NULL, NULL, NULL, time(), time()],
            ['/site/login', 2, NULL, NULL, NULL, time(), time()],
            ['/site/logout', 2, NULL, NULL, NULL, time(), time()],
            ['/site/page', 2, NULL, NULL, NULL, time(), time()],
            ['/site/password-reset', 2, NULL, NULL, NULL, time(), time()],
            ['/site/request-password-reset', 2, NULL, NULL, NULL, time(), time()],
            ['/site/signup', 2, NULL, NULL, NULL, time(), time()],
            ['/site/account', 2, NULL, NULL, NULL, time(), time()],
            ['admin', 1, 'admin role', NULL, NULL, time(), time()],
            ['account', 2, 'user can view account information', NULL, NULL, time(), time()],
            ['adminManage', 2, 'user can manage admin settings', NULL, NULL, time(), time()],
            ['contactUs', 2, 'user can send email via contact form', NULL, NULL, time(), time()],
            ['error', 2, 'view error', NULL, NULL, time(), time()],
            ['guest', 1, 'guest role', 'guest', NULL, time(), time()],
            ['login', 2, 'user can login', NULL, NULL, time(), time()],
            ['logout', 2, 'user can logout', NULL, NULL, time(), time()],
            ['signup', 2, 'User can sign up', NULL, NULL, time(), time()],
            ['user', 1, 'default user role', 'user', NULL, time(), time()],
            ['viewCmsPage', 2, 'user can view cms pages', NULL, NULL, time(), time()],
            ['viewHomePage', 2, 'user can view home page', NULL, NULL, time(), time()],
            ['repairPassword', 2, 'user can repair own password', NULL, NULL, time(), time()],
        ]);

        $this->batchInsert('{{%AuthItemChild}}', ['parent', 'child'], [
            ['repairPassword', '/site/password-reset'],
            ['repairPassword', '/site/request-password-reset'],
            ['guest', 'repairPassword'],
            ['adminManage', '/admin/*'],
            ['contactUs', '/site/captcha'],
            ['contactUs', '/site/contact'],
            ['account', '/site/account'],
            ['error', '/site/error'],
            ['viewHomePage', '/site/index'],
            ['login', '/site/login'],
            ['logout', '/site/logout'],
            ['viewCmsPage', '/site/page'],
            ['signup', '/site/signup'],
            ['admin', 'adminManage'],
            ['guest', 'contactUs'],
            ['user', 'contactUs'],
            ['guest', 'error'],
            ['user', 'error'],
            ['guest', 'login'],
            ['user', 'logout'],
            ['guest', 'signup'],
            ['guest', 'viewCmsPage'],
            ['user', 'viewCmsPage'],
            ['guest', 'viewHomePage'],
            ['user', 'viewHomePage'],
            ['user', 'account'],
        ]);

        $this->batchInsert('{{%AuthRule}}', ['name', 'data', 'created_at', 'updated_at'], [
            [
                'guest',
                'O:28:"yii2mod\rbac\rules\GuestRule":3:{s:4:"name";s:5:"guest";s:9:"createdAt";i:1469117870;s:9:"updatedAt";i:1469117870;}',
                time(),
                time()
            ],
            [
                'user',
                'O:27:"yii2mod\rbac\rules\UserRule":3:{s:4:"name";s:4:"user";s:9:"createdAt";i:1469117882;s:9:"updatedAt";i:1469117882;}',
                time(),
                time()
            ]
        ]);

        $this->execute('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Down
     * @return bool|void
     */
    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0;');
        $this->dropTable('{{%User}}');
        $this->dropTable('{{%Cms}}');
        $this->dropTable('{{%Comment}}');
        $this->dropTable('{{%Session}}');
        $this->dropTable('{{%AuthAssignment}}');
        $this->dropTable('{{%AuthItemChild}}');
        $this->dropTable('{{%AuthItem}}');
        $this->dropTable('{{%AuthRule}}');
        $this->dropTable('{{%CronSchedule}}');
        $this->dropTable('{{%Setting}}');
        $this->execute('SET FOREIGN_KEY_CHECKS=1;');
    }
}

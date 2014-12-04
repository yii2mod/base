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
        $this->createTable('CronSchedule', [
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

        //Insert admin user
        $this->insert('User', [
            'id' => 1,
            'username' => 'admin',
            'authKey' => '6OFUxxVvoz067LISkZBY0JmZ-30NJK5j',
            'passwordHash' => '$2y$13$BtICgI3WpoMuUe3/t4AXOuRQD6cx90mttQUfi7uYkC2nvGE8dh4Ve',
            'passwordResetToken' => 'FFFONvY8njNEkm16-czMKmoWSQtT9eoC_1417103710',
            'email' => 'admin@mail.com',
            'status' => 1,
            'createdAt' => 1417101427,
            'updatedAt' => 1417101427,
        ]);

        $this->insert('UserDetails', [
            'userId' => 1,
        ]);
        $this->execute('SET FOREIGN_KEY_CHECKS=0;');
        //Insert auth assignment
        $this->insert('AuthAssignment', [
            'itemName' => 'admin',
            'userId' => 1,
            'createdAt' => 1417165845,
        ]);
       //insest auth item
        $this->insert('AuthItem', [
            'name' => '/admin/*',
            'type' => 2,
            'description' => NULL,
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => '/site/captcha',
            'type' => 2,
            'description' => NULL,
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => '/site/contact',
            'type' => 2,
            'description' => NULL,
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => '/site/error',
            'type' => 2,
            'description' => NULL,
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => '/site/index',
            'type' => 2,
            'description' => NULL,
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => '/site/login',
            'type' => 2,
            'description' => NULL,
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => '/site/logout',
            'type' => 2,
            'description' => NULL,
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => '/site/page',
            'type' => 2,
            'description' => NULL,
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => '/site/password-reset',
            'type' => 2,
            'description' => NULL,
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => '/site/request-password-reset',
            'type' => 2,
            'description' => NULL,
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => '/site/signup',
            'type' => 2,
            'description' => NULL,
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => 'admin',
            'type' => 1,
            'description' => 'admin role',
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => 'adminManage',
            'type' => 2,
            'description' => 'user can manage admin settings',
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => 'contactUs',
            'type' => 2,
            'description' => 'user can send email via contact form',
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => 'error',
            'type' => 2,
            'description' => 'view error',
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => 'guest',
            'type' => 1,
            'description' => 'guest role',
            'ruleName' => 'guest',
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => 'login',
            'type' => 2,
            'description' => 'user can login',
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => 'logout',
            'type' => 2,
            'description' => 'user can logout',
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => 'signup',
            'type' => 2,
            'description' => 'User can sign up',
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => 'user',
            'type' => 1,
            'description' => 'default user role',
            'ruleName' => 'user',
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => 'viewCmsPage',
            'type' => 2,
            'description' => 'user can view cms pages',
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => 'viewHomePage',
            'type' => 2,
            'description' => 'user can view home page',
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItem', [
            'name' => 'repairPassword',
            'type' => 2,
            'description' => 'user can repair own password',
            'ruleName' => NULL,
            'data' => NULL,
            'createdAt' => 1417165845,
            'updatedAt' => 1417165845,
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'repairPassword',
            'child' => '/site/password-reset',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'repairPassword',
            'child' => '/site/request-password-reset',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'guest',
            'child' => 'repairPassword',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'adminManage',
            'child' => '/admin/*',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'contactUs',
            'child' => '/site/captcha',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'contactUs',
            'child' => '/site/contact',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'error',
            'child' => '/site/error',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'viewHomePage',
            'child' => '/site/index',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'login',
            'child' => '/site/login',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'logout',
            'child' => '/site/logout',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'viewCmsPage',
            'child' => '/site/page',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'signup',
            'child' => '/site/signup',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'admin',
            'child' => 'adminManage',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'admin',
            'child' => 'contactUs',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'guest',
            'child' => 'contactUs',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'user',
            'child' => 'contactUs',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'admin',
            'child' => 'error',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'guest',
            'child' => 'error',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'user',
            'child' => 'error',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'guest',
            'child' => 'login',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'admin',
            'child' => 'logout',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'user',
            'child' => 'logout',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'guest',
            'child' => 'signup',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'admin',
            'child' => 'viewCmsPage',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'guest',
            'child' => 'viewCmsPage',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'user',
            'child' => 'viewCmsPage',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'admin',
            'child' => 'viewHomePage',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'guest',
            'child' => 'viewHomePage',
        ]);
        $this->insert('AuthItemChild', [
            'parent' => 'user',
            'child' => 'viewHomePage',
        ]);
        //Insert auth rules
        $this->insert('AuthRule', [
            'name' => 'guest',
            'data' => 'O:31:"yii2mod\\rbac\\components\\BizRule":4:{s:10:"expression";s:32:"return Yii::$app->user->isGuest;";s:4:"name";s:5:"guest";s:9:"createdAt";i:1417110668;s:9:"updatedAt";i:1417110668;}',
            'createdAt' => 1417101427,
            'updatedAt' => 1417101427,
        ]);
        $this->insert('AuthRule', [
            'name' => 'user',
            'data' => 'O:31:"yii2mod\\rbac\\components\\BizRule":4:{s:10:"expression";s:33:"return !Yii::$app->user->isGuest;";s:4:"name";s:4:"user";s:9:"createdAt";i:1417165484;s:9:"updatedAt";i:1417165484;}',
            'createdAt' => 1417101427,
            'updatedAt' => 1417101427,
        ]);
        $this->execute('SET FOREIGN_KEY_CHECKS=1;');
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

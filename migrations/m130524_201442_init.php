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
        $this->createTable('{{%UserDetails}}', [
            'userId' => Schema::TYPE_PK,
            'FOREIGN KEY (userId) REFERENCES {{%User}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
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
        ]);

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
        $this->createTable('{{%CronSchedule}}',[
                'id' => Schema::TYPE_PK,
                'jobCode' => Schema::TYPE_STRING . '(255) NULL DEFAULT NULL',
                'status' => Schema::TYPE_SMALLINT . ' NOT NULL',
                'messages' => Schema::TYPE_TEXT . ' NULL',
                'dateCreated' => Schema::TYPE_TIMESTAMP . ' NULL DEFAULT NULL',
                'dateScheduled' => Schema::TYPE_TIMESTAMP . ' NULL DEFAULT NULL',
                'dateExecuted' => Schema::TYPE_TIMESTAMP . ' NULL DEFAULT NULL',
                'dateFinished' => Schema::TYPE_TIMESTAMP . ' NULL DEFAULT NULL',
            ],
            $tableOptions
        );

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
            'createdAt' => 1417101427,
            'updatedAt' => 1417101427,
        ]);

        $this->insert('{{%UserDetails}}', [
            'userId' => 1,
        ]);
        $this->execute('SET FOREIGN_KEY_CHECKS=0;');
        //Insert auth assignment
        $this->insert('{{%AuthAssignment}}', [
            'item_name' => 'admin',
            'user_id' => 1,
            'created_at' => 1417165845,
        ]);
        //insert auth item
        $this->batchInsert('{{%AuthItem}}', ['name', 'type', 'description', 'rule_name', 'data', 'created_at', 'updated_at'], [
            ['/admin/*', 2, NULL, NULL, NULL, 1417165845, 1417165845],
            ['/site/captcha', 2, NULL, NULL, NULL, 1417165845, 1417165845],
            ['/site/contact', 2, NULL, NULL, NULL, 1417165845, 1417165845],
            ['/site/error', 2, NULL, NULL, NULL, 1417165845, 1417165845],
            ['/site/index', 2, NULL, NULL, NULL, 1417165845, 1417165845],
            ['/site/login', 2, NULL, NULL, NULL, 1417165845, 1417165845],
            ['/site/logout', 2, NULL, NULL, NULL, 1417165845, 1417165845],
            ['/site/page', 2, NULL, NULL, NULL, 1417165845, 1417165845],
            ['/site/password-reset', 2, NULL, NULL, NULL, 1417165845, 1417165845],
            ['/site/request-password-reset', 2, NULL, NULL, NULL, 1417165845, 1417165845],
            ['/site/signup', 2, NULL, NULL, NULL, 1417165845, 1417165845],
            ['admin', 1, 'admin role', NULL, NULL, 1417165845, 1417165845],
            ['adminManage', 2, 'user can manage admin settings', NULL, NULL, 1417165845, 1417165845],
            ['contactUs', 2, 'user can send email via contact form', NULL, NULL, 1417165845, 1417165845],
            ['error', 2, 'view error', NULL, NULL, 1417165845, 1417165845],
            ['guest', 1, 'guest role', 'guest', NULL, 1417165845, 1417165845],
            ['login', 2, 'user can login', NULL, NULL, 1417165845, 1417165845],
            ['logout', 2, 'user can logout', NULL, NULL, 1417165845, 1417165845],
            ['signup', 2, 'User can sign up', NULL, NULL, 1417165845, 1417165845],
            ['user', 1, 'default user role', 'user', NULL, 1417165845, 1417165845],
            ['viewCmsPage', 2, 'user can view cms pages', NULL, NULL, 1417165845, 1417165845],
            ['viewHomePage', 2, 'user can view home page', NULL, NULL, 1417165845, 1417165845],
            ['repairPassword', 2, 'user can repair own password', NULL, NULL, 1417165845, 1417165845],
        ]);

        $this->batchInsert('{{%AuthItemChild}}', ['parent', 'child'], [
            ['repairPassword', '/site/password-reset'],
            ['repairPassword', '/site/request-password-reset'],
            ['guest', 'repairPassword'],
            ['adminManage', '/admin/*'],
            ['contactUs', '/site/captcha'],
            ['contactUs', '/site/contact'],
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
            ['user', 'viewHomePage']
        ]);

        $this->batchInsert('{{%AuthRule}}', ['name', 'data', 'created_at', 'updated_at'], [
            [
                'guest',
                'O:31:"yii2mod\\rbac\\components\\BizRule":4:{s:10:"expression";s:32:"return Yii::$app->user->isGuest;";s:4:"name";s:5:"guest";s:9:"createdAt";i:1417110668;s:9:"updatedAt";i:1417110668;}',
                1417101427,
                1417101427
            ],
            [
                'user',
                'O:31:"yii2mod\\rbac\\components\\BizRule":4:{s:10:"expression";s:33:"return !Yii::$app->user->isGuest;";s:4:"name";s:4:"user";s:9:"createdAt";i:1417165484;s:9:"updatedAt";i:1417165484;}',
                1417101427,
                1417101427
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
        //Drop user & userDetails tables
        $this->dropTable('{{%User}}');
        $this->dropTable('{{%UserDetails}}');
        //Drop cms and comment tables
        $this->dropTable('{{%Cms}}');
        $this->dropTable('{{%Comment}}');
        //Drop session table
        $this->dropTable('{{%Session}}');
        //Drop auth tables
        $this->dropTable('{{%AuthAssignment}}');
        $this->dropTable('{{%AuthItemChild}}');
        $this->dropTable('{{%AuthItem}}');
        $this->dropTable('{{%AuthRule}}');
        //Drop cron table
        $this->dropTable('{{%CronSchedule}}');
        $this->execute('SET FOREIGN_KEY_CHECKS=1;');
    }
}

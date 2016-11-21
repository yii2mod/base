<?php

use yii2mod\rbac\migrations\Migration;

class m160722_085418_init extends Migration
{
    public function safeUp()
    {
        // create rules
        $this->createRule('guest', \yii2mod\rbac\rules\GuestRule::className());
        $this->createRule('user', \yii2mod\rbac\rules\UserRule::className());

        // create roles
        $this->createRole('admin', 'admin has all available permissions.');
        $this->createRole('user', 'user can view own account page.', 'user');
        $this->createRole('guest', 'guest can login and signup.', 'guest');

        // create permissions
        $this->createPermission('/admin/*');
        $this->createPermission('/site/captcha');
        $this->createPermission('/site/contact');
        $this->createPermission('/site/error');
        $this->createPermission('/site/index');
        $this->createPermission('/site/login');
        $this->createPermission('/site/logout');
        $this->createPermission('/site/page');
        $this->createPermission('/site/password-reset');
        $this->createPermission('/site/request-password-reset');
        $this->createPermission('/site/signup');
        $this->createPermission('/site/account');
        $this->createPermission('account', 'User has access to the account page.');
        $this->createPermission('adminManage', 'User has access to the administration panel.');
        $this->createPermission('contactUs', 'User has access to the contact us page.');
        $this->createPermission('error', 'User has access to the error page.');
        $this->createPermission('login', 'User has access to the login page.');
        $this->createPermission('logout', 'User can logout.');
        $this->createPermission('signup', 'User has access to the signup page.');
        $this->createPermission('viewCmsPage', 'User can view cms pages.');
        $this->createPermission('viewHomePage', 'User has access to the homepage.');
        $this->createPermission('repairPassword', 'User can reset password.');

        // add child
        $this->addChild('repairPassword', '/site/request-password-reset');
        $this->addChild('repairPassword', '/site/password-reset');
        $this->addChild('guest', 'repairPassword');
        $this->addChild('adminManage', '/admin/*');
        $this->addChild('contactUs', '/site/captcha');
        $this->addChild('contactUs', '/site/contact');
        $this->addChild('account', '/site/account');
        $this->addChild('error', '/site/error');
        $this->addChild('viewHomePage', '/site/index');
        $this->addChild('login', '/site/login');
        $this->addChild('logout', '/site/logout');
        $this->addChild('viewCmsPage', '/site/page');
        $this->addChild('signup', '/site/signup');
        $this->addChild('admin', 'adminManage');
        $this->addChild('guest', 'contactUs');
        $this->addChild('user', 'contactUs');
        $this->addChild('guest', 'error');
        $this->addChild('user', 'error');
        $this->addChild('guest', 'login');
        $this->addChild('user', 'logout');
        $this->addChild('guest', 'signup');
        $this->addChild('guest', 'viewCmsPage');
        $this->addChild('user', 'viewCmsPage');
        $this->addChild('guest', 'viewHomePage');
        $this->addChild('user', 'viewHomePage');
        $this->addChild('user', 'account');

        $this->assign('admin', 1);
    }

    public function safeDown()
    {
        // remove rules
        $this->removeRule('guest');
        $this->removeRule('user');

        // remove roles
        $this->removeRole('admin');
        $this->removeRole('user');
        $this->removeRole('guest');

        // remove permissions
        $this->removePermission('/admin/*');
        $this->removePermission('/site/captcha');
        $this->removePermission('/site/contact');
        $this->removePermission('/site/error');
        $this->removePermission('/site/index');
        $this->removePermission('/site/login');
        $this->removePermission('/site/logout');
        $this->removePermission('/site/page');
        $this->removePermission('/site/password-reset');
        $this->removePermission('/site/request-password-reset');
        $this->removePermission('/site/signup');
        $this->removePermission('/site/account');
        $this->removePermission('account');
        $this->removePermission('adminManage');
        $this->removePermission('contactUs');
        $this->removePermission('error');
        $this->removePermission('login');
        $this->removePermission('logout');
        $this->removePermission('signup');
        $this->removePermission('viewCmsPage');
        $this->removePermission('viewHomePage');
        $this->removePermission('repairPassword');
    }
}

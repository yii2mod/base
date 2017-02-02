<?php

namespace app\tests\functional;

use FunctionalTester;

class AdminLoginCest
{
    protected $formId = '#login-form';

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[email]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkLogin(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('admin@example.org', '123123'));
        $I->see('Logout (admin)', 'form button[type=submit]');
        $I->seeLink('Administration');
    }

    public function checkAdminPanel(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('admin@example.org', '123123'));
        $I->see('Logout (admin)', 'form button[type=submit]');
        $I->seeLink('Administration');
        $I->click('Administration');
        $I->see('Users');
        $I->seeLink('CMS');
        $I->seeLink('RBAC');
        $I->seeLink('Settings Storage');
        $I->seeLink('Cron Schedule Log');
    }
}

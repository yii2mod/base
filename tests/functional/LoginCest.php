<?php

namespace app\tests\functional;

use app\tests\fixtures\UserAssignmentFixture;
use FunctionalTester;

class LoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserAssignmentFixture::class,
            ],
        ]);
        $I->amOnRoute('site/login');
    }

    public function checkEmpty(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('', ''));
        $I->see('Email cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function checkWrongEmail(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('admin', 'wrong'));
        $I->see('Email is not a valid email address.');
    }

    public function checkWrongPassword(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('admin@example.org', 'wrong'));
        $I->see('Incorrect email or password.');
    }

    public function checkValidLogin(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('admin@example.org', '123123'));
        $I->see('Logout (admin)', 'form button[type=submit]');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[email]' => $login,
            'LoginForm[password]' => $password,
        ];
    }
}

<?php

namespace app\tests\functional;

use app\tests\fixtures\UserAssignmentFixture;
use FunctionalTester;

class ChangePasswordViaAccountPageCest
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
        $I->submitForm('#login-form', $this->loginFormParams('test-user@example.com', '123123'));
        $I->click('My Account');
        $I->submitForm('#change-password-form', $this->resetPasswordFormParams('', ''));
        $I->see('New Password cannot be blank.');
        $I->see('Confirm New Password cannot be blank.');
    }

    public function checkNotEqual(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->loginFormParams('test-user@example.com', '123123'));
        $I->click('My Account');
        $I->submitForm('#change-password-form', $this->resetPasswordFormParams('123123', '123456'));
        $I->see('Confirm New Password must be equal to "New Password".');
    }

    public function checkCorrectChangePassword(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->loginFormParams('test-user@example.com', '123123'));
        $I->click('My Account');
        $I->submitForm('#change-password-form', $this->resetPasswordFormParams('123456', '123456'));
        $I->see('Password has been updated.');
    }

    protected function loginFormParams($login, $password)
    {
        return [
            'LoginForm[email]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    protected function resetPasswordFormParams($newPassword, $confirmPassword)
    {
        return [
            'ResetPasswordForm[password]' => $newPassword,
            'ResetPasswordForm[confirmPassword]' => $confirmPassword,
        ];
    }
}

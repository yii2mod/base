<?php

class CreateUserCest
{
    protected $loginFormId = '#login-form';
    protected $createUserFormId = '#create-user-form';

    protected function loginFormParams($login, $password)
    {
        return [
            'LoginForm[email]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    protected function createUserFormParams($username, $email, $password)
    {
        return [
            'UserModel[username]' => $username,
            'UserModel[email]' => $email,
            'UserModel[newPassword]' => $password,
        ];
    }

    public function createUser(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->submitForm($this->loginFormId, $this->loginFormParams('admin@example.org', '123123'));
        $I->amOnRoute('/admin/user/create');
        $I->see('Create User');
        $I->submitForm($this->createUserFormId, $this->createUserFormParams('created-user', 'created-user@example.com', '123123'));
        $I->seeRecord('app\models\UserModel', [
            'username' => 'created-user',
            'email' => 'created-user@example.com',
        ]);
    }
}

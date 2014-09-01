<?php

namespace codeception\_pages;

use yii\codeception\BasePage;

/**
 * Represents login page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class LoginPage extends BasePage
{
    public $route = 'user/login';

    /**
     * @param string $email
     * @param string $password
     */
    public function login($email, $password)
    {
        $this->actor->fillField('input[name="LoginForm[email]"]', $email);
        $this->actor->fillField('input[name="LoginForm[password]"]', $password);
        $this->actor->click('login-button');
    }
}

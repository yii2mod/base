<?php

namespace app\tests\unit\models;

use app\tests\fixtures\UserAssignmentFixture;
use Yii;
use yii2mod\user\models\LoginForm;

class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var LoginForm
     */
    private $_model;

    public function testLoginNoUser()
    {
        $this->_model = new LoginForm([
            'email' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        expect_not($this->_model->login());
        expect_that(Yii::$app->user->isGuest);
    }

    public function testLoginWrongPassword()
    {
        $this->_model = new LoginForm([
            'email' => 'demo@example.com',
            'password' => 'wrong_password',
        ]);

        expect_not($this->_model->login());
        expect_that(Yii::$app->user->isGuest);
        expect($this->_model->errors)->hasKey('password');
    }

    public function testLoginCorrect()
    {
        $this->_model = new LoginForm([
            'email' => 'admin@example.org',
            'password' => '123123',
        ]);

        expect_that($this->_model->login());
        expect_not(Yii::$app->user->isGuest);
        expect($this->_model->errors)->hasntKey('password');
    }

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserAssignmentFixture::class,
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function _after()
    {
        Yii::$app->user->logout();
    }
}

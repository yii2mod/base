<?php

namespace tests\models;

use app\tests\fixtures\UserFixture;
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
    private $model;

    protected function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className()
            ]
        ]);
    }

    protected function _after()
    {
        Yii::$app->user->logout();
    }

    public function testLoginNoUser()
    {
        $this->model = new LoginForm([
            'email' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);
        expect_not($this->model->login());
        expect_that(Yii::$app->user->isGuest);
    }

    public function testLoginWrongPassword()
    {
        $this->model = new LoginForm([
            'email' => 'demo@example.com',
            'password' => 'wrong_password',
        ]);
        expect_not($this->model->login());
        expect_that(Yii::$app->user->isGuest);
        expect($this->model->errors)->hasKey('password');
    }

    public function testLoginCorrect()
    {
        $this->model = new LoginForm([
            'email' => 'admin@example.org',
            'password' => '123123',
        ]);
        expect_that($this->model->login());
        expect_not(Yii::$app->user->isGuest);
        expect($this->model->errors)->hasntKey('password');
    }
}

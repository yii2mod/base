<?php

namespace app\tests\unit\models;

use app\tests\fixtures\UserAssignmentFixture;
use yii2mod\user\models\SignupForm;

class SignupFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
        ]);

        $user = $model->signup();

        expect($user)->isInstanceOf('yii2mod\user\models\UserModel');

        expect($user->username)->equals('some_username');
        expect($user->email)->equals('some_email@example.com');
        expect($user->validatePassword('some_password'))->true();
    }

    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'test-user',
            'email' => 'test-user@example.com',
            'password' => 'some_password',
        ]);

        expect_not($model->signup());
        expect_that($model->getErrors('username'));
        expect_that($model->getErrors('email'));

        expect($model->getFirstError('username'))
            ->equals('This username has already been taken.');
        expect($model->getFirstError('email'))
            ->equals('This email address has already been taken.');
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
}

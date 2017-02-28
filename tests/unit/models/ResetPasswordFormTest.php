<?php

namespace app\tests\unit\models;

use app\models\forms\ResetPasswordForm;
use app\models\UserModel;
use app\tests\fixtures\UserAssignmentFixture;
use Yii;

class ResetPasswordFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;

    /**
     * @var ResetPasswordForm
     */
    private $_model;

    public function testCheckEmptyForm()
    {
        $user = UserModel::findOne(['email' => 'test-user@example.com']);
        $this->_model = new ResetPasswordForm($user);

        expect($this->_model->resetPassword())->false();
        expect($this->_model->errors)->hasKey('password');
        expect($this->_model->errors)->hasKey('confirmPassword');
    }

    public function testCheckInvalidConfirmPassword()
    {
        $user = UserModel::findOne(['email' => 'test-user@example.com']);
        $this->_model = new ResetPasswordForm($user, [
            'password' => '123123',
            'confirmPassword' => '123456',
        ]);

        expect($this->_model->resetPassword())->false();
        expect($this->_model->errors)->hasKey('confirmPassword');
    }

    public function testCorrectResetPassword()
    {
        $user = UserModel::findOne(['email' => 'test-user@example.com']);
        $this->_model = new ResetPasswordForm($user, [
            'password' => '123456',
            'confirmPassword' => '123456',
        ]);

        expect($this->_model->resetPassword())->true();
        expect($this->_model->errors)->isEmpty();
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

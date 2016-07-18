<?php

namespace app\models\forms;

use app\models\UserModel;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Class ResetPasswordForm
 * @package app\models\forms
 */
class ResetPasswordForm extends Model
{
    /**
     * @var string Password
     */
    public $password;

    /**
     * @var string confirmPassword
     */
    public $confirmPassword;

    /**
     * @var UserModel
     */
    private $_user;

    /**
     * Construct
     *
     * @param UserModel $user
     * @param  array $config name-value pairs that will be used to initialize the object properties
     *
     * @throws InvalidConfigException
     */
    public function __construct($user, $config = [])
    {
        $this->_user = $user;
        if (!$this->_user) {
            throw new InvalidConfigException('UserModel must be set.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'confirmPassword'], 'trim'],
            ['password', 'required'],
            ['confirmPassword', 'required'],
            [['password', 'confirmPassword'], 'string', 'min' => 6],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('user', 'New Password'),
            'confirmPassword' => Yii::t('user', 'Confirm New Password'),
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        if ($this->validate()) {
            $user->setPassword($this->password);
            return $user->save(true, ['passwordHash']);
        } else {
            return false;
        }
    }
}
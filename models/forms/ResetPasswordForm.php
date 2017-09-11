<?php

namespace app\models\forms;

use app\models\UserModel;
use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;

/**
 * Class ResetPasswordForm
 *
 * @package app\models\forms
 */
class ResetPasswordForm extends Model
{
    /**
     * @var string password
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
     * ResetPasswordForm constructor.
     *
     * @param IdentityInterface $user
     * @param array $config
     */
    public function __construct(IdentityInterface $user, array $config = [])
    {
        $this->_user = $user;

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
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
    public function attributeLabels(): array
    {
        return [
            'password' => Yii::t('app', 'New Password'),
            'confirmPassword' => Yii::t('app', 'Confirm New Password'),
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset
     */
    public function resetPassword(): bool
    {
        if ($this->validate()) {
            $this->_user->setPassword($this->password);

            return $this->_user->save(true, ['password_hash']);
        }

        return false;
    }
}

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
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     * @return array validation rules
     * @see scenarios()
     */
    public function rules()
    {
        return [
            [['password', 'confirmPassword'], 'filter', 'filter' => 'trim'],
            ['password', 'required'],
            ['confirmPassword', 'required'],
            [['password', 'confirmPassword'], 'string', 'min' => '3'],
            [['password', 'confirmPassword'], 'match', 'pattern' => '/^[a-z0-9]+$/i'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * Attribute labels are mainly used for display purpose. For example, given an attribute
     * `firstName`, we can declare a label `First Name` which is more user-friendly and can
     * be displayed to end users.
     *
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'New Password'),
            'confirmPassword' => Yii::t('app', 'Confirm New Password'),
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

<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii2mod\user\models\BaseUserDetailsModel;
use yii2mod\user\models\BaseUserModel;

/**
 * Class UserModel
 * @package app\models
 */
class UserModel extends BaseUserModel
{
    /**
     * @var string password field
     */
    public $password;

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
        return ArrayHelper::merge([
            [['username', 'email'], 'required'],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],
            ['username', 'unique', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 30],
            ['email','email'],
            ['password', 'string', 'min' => 6, 'max' => 24],
            ['password', 'required', 'on' => 'createUser'],
        ], parent::rules());
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
        return ArrayHelper::merge([
            //Extends AttributeLabels
        ], parent::attributeLabels());
    }

    /**
     * Returns a list of scenarios and the corresponding active attributes.
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return $scenarios;
    }
	
    /**
     * @inheritdoc
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //Update user password, if password is not blank
            if (!$this->isNewRecord && !empty($this->password)) {
                $this->setPassword($this->password);
            }
            return true;
        } else {
            return false;
        }
    }	
	
    /**
     * Create user
     * @return UserModel|null the saved model or null if saving fails
     */
    public function createUser()
    {
        if ($this->validate()) {
            $this->setPassword($this->password);
            $this->generateAuthKey();
            if ($this->save()) {
                $userDetailsModels = new BaseUserDetailsModel();
                $userDetailsModels->userId = $this->primaryKey;
                $userDetailsModels->save();
            }
            return $this;
        }

        return false;
    }

}

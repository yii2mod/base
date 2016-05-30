<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii2mod\user\models\BaseUserDetailsModel;
use yii2mod\user\models\BaseUserModel;

/**
 * This is the model class for table "User".
 *
 * @property UserDetailsModel $userDetails
 */
class UserModel extends BaseUserModel
{
    /**
     * @var string newPassword - for creation user and changing password
     */
    public $newPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['username', 'email'], 'required'],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],
            ['username', 'unique', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 30],
            ['email', 'email'],
            ['newPassword', 'string', 'min' => 6, 'max' => 24],
            ['newPassword', 'required', 'on' => 'createUser'],
        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'newPassword' => $this->isNewRecord ? Yii::t('app', 'Password') : Yii::t('app', 'New Password'),
        ], parent::attributeLabels());
    }

    /**
     * Create user
     * @return UserModel|null the saved model or null if saving fails
     */
    public function createUser()
    {
        if ($this->validate()) {
            $this->setPassword($this->newPassword);
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
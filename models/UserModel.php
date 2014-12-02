<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii2mod\user\models\BaseUserModel;

/**
 * Class UserModel
 * @package app\models
 */
class UserModel extends BaseUserModel
{

    /**
     * Rules
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['username', 'email'], 'required'],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 30],
        ], parent::rules());
    }

    /**
     * Attribute Labels
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            //Extends AttributeLabels
        ], parent::attributeLabels());
    }

}
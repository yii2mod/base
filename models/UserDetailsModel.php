<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use Yii;
use yii2mod\user\models\BaseUserDetailsModel;
use yii2mod\user\models\BaseUserModel;

/**
 * This is the model class for table "UserDetails".
 *
 * @property UserModel $user
 */
class UserDetailsModel extends BaseUserDetailsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            //Extends rules
        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            //Extends AttributeLabels
        ], parent::attributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'userId']);
    }
}
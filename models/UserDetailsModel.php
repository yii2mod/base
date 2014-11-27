<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use Yii;
use yii2mod\user\models\BaseUserDetailsModel;

/**
 * UserDetails model
 * @author Igor Chepurnoy
 */
class UserDetailsModel extends BaseUserDetailsModel
{

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     */
    public function rules()
    {
        return ArrayHelper::merge([
            //Extends rules
        ], parent::rules());
    }

    /**
     * Returns the text label for the specified attribute.
     * If the attribute looks like `relatedModel.attribute`, then the attribute will be received from the related model.
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            //Extends AttributeLabels
        ], parent::attributeLabels());
    }

    /**
     * User relation
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'userId']);
    }
}
<?php

namespace app\models;

use yii\data\ActiveDataProvider;

/**
 * Class UserModelSearch
 * @package app\models
 */
class UserModelSearch extends UserModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'id', 'createdAt', 'email', 'status'], 'safe'],
        ];
    }

    /**
     * Setup search function for filtering and sorting based on fullName field
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);


        // load the search form data and validate
        if (!($this->load($params))) {
            return $dataProvider;
        }

        //adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

} 
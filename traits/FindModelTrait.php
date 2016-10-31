<?php

namespace app\traits;

use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * Class FindModelTrait
 * @package app\traits
 */
trait FindModelTrait
{
    /**
     * Finds model
     *
     * @param $modelClass ActiveRecord
     * @param mixed $condition primary key value or a set of column values
     * @param string $notFoundMessage
     * @return ActiveRecord
     *
     * @throws NotFoundHttpException
     */
    protected function findModel($modelClass, $condition, $notFoundMessage = 'The requested page does not exist.')
    {
        if (($model = $modelClass::findOne($condition)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException($notFoundMessage);
        }
    }
}

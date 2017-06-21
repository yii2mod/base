<?php

namespace app\traits;

use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * Class FindModelTrait
 *
 * @author Igor Chepurnoy <chepurnoi.igor@gmail.com>
 *
 * @since 1.0
 */
trait FindModelTrait
{
    /**
     * Finds model
     *
     * @param mixed $modelClass
     * @param mixed $condition primary key value or a set of column values
     * @param string $notFoundMessage
     *
     * @throws NotFoundHttpException
     *
     * @return ActiveRecord
     */
    protected function findModel($modelClass, $condition, string $notFoundMessage = 'The requested page does not exist.')
    {
        if (($model = $modelClass::findOne($condition)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException($notFoundMessage);
        }
    }

    /**
     * @param mixed $modelClass
     * @param mixed $condition primary key value or a set of column values
     *
     * @return ActiveRecord
     */
    protected function findModelOrCreate($modelClass, $condition)
    {
        if (($model = $modelClass::findOne($condition)) !== null) {
            return $model;
        } else {
            return new $modelClass($condition);
        }
    }
}

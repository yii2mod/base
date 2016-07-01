<?php

namespace app\traits;

use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * Class FindModelTrait
 * @package app\traits
 */
trait FindModelTrait
{
    /**
     * @var string message for the NotFoundHttpException
     */
    protected $notFoundMessage = 'The requested page does not exist.';

    /**
     * Finds model
     *
     * @param $modelClass ActiveRecord
     * @param mixed $condition primary key value or a set of column values
     * @return ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($modelClass, $condition)
    {
        if (($model = $modelClass::findOne($condition)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException($this->notFoundMessage);
        }
    }
}
<?php

namespace app\traits;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class AjaxValidationTrait performs ajax validation.
 * @package app\traits
 *
 * ~~~
 *  // in your controller
 *
 *  use AjaxValidationTrait;
 *
 *  // in your action
 *
 *  $model = new User;
 *  $this->performAjaxValidation($model);
 *  .....
 * ~~~
 */
trait AjaxValidationTrait
{
    /**
     * Performs ajax validation.
     *
     * @param Model $model
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation(Model $model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            echo Json::encode(ActiveForm::validate($model));
            Yii::$app->end();
        }
    }
}
<?php

namespace app\modules\admin\controllers;

use app\models\UserModelSearch;
use app\traits\FindModelTrait;
use Yii;
use app\models\UserModel;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii2mod\editable\EditableAction;

/**
 * Class UserController
 * @package app\modules\admin\controllers
 */
class UserController extends Controller
{
    use FindModelTrait;

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'delete' => ['post']
                ],
            ],
        ];
    }

    /**
     * Declares external actions for the controller.
     *
     * @return array
     */
    public function actions()
    {
        return [
            'edit-user' => [
                'class' => EditableAction::className(),
                'modelClass' => UserModel::className(),
                'forceCreate' => false
            ],
            'index' => [
                'class' => 'yii2tech\admin\actions\Index',
                'newSearchModel' => function () {
                    return new UserModelSearch();
                },
            ],
            'delete' => [
                'class' => 'yii2tech\admin\actions\Delete',
                'findModel' => function ($id) {
                    return $this->findModel(UserModel::className(), $id);
                },
                'flash' => 'User has been deleted.'
            ],
        ];
    }

    /**
     * Creates a new UserModel model.
     *
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserModel(['scenario' => 'createUser']);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->createUser()) {
                Yii::$app->session->setFlash('success', 'User has been created.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserModel model.
     *
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel(UserModel::className(), $id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!empty($model->newPassword)) {
                $model->setPassword($model->newPassword);
            }
            $model->save(false);
            Yii::$app->session->setFlash('success', 'User has been saved.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
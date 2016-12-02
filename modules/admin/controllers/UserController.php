<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\search\UserSearch;
use app\models\UserModel;
use app\traits\FindModelTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii2mod\editable\EditableAction;

/**
 * Class UserController
 *
 * @package app\modules\admin\controllers
 */
class UserController extends Controller
{
    use FindModelTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'edit-user' => [
                'class' => EditableAction::class,
                'modelClass' => UserModel::class,
                'forceCreate' => false,
            ],
            'index' => [
                'class' => 'yii2tech\admin\actions\Index',
                'newSearchModel' => function () {
                    return new UserSearch();
                },
            ],
            'delete' => [
                'class' => 'yii2tech\admin\actions\Delete',
                'findModel' => function ($id) {
                    return $this->findModel(UserModel::class, $id);
                },
                'flash' => Yii::t('user', 'User has been deleted.'),
            ],
        ];
    }

    /**
     * Creates a new user.
     *
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserModel(['scenario' => 'createUser']);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->createUser()) {
                Yii::$app->session->setFlash('success', Yii::t('user', 'User has been created.'));

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing user.
     *
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel(UserModel::class, $id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!empty($model->newPassword)) {
                $model->setPassword($model->newPassword);
            }
            $model->save(false);
            Yii::$app->session->setFlash('success', Yii::t('user', 'User has been saved.'));

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}

<?php

namespace app\modules\admin\controllers;

use app\models\UserModel;
use app\modules\admin\models\search\UserSearch;
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
                'flash' => Yii::t('app', 'User has been deleted.'),
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
        $model = new UserModel(['scenario' => 'create']);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->create()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'User has been created.'));

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
        /* @var $model UserModel */
        $model = $this->findModel(UserModel::class, $id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!empty($model->plainPassword)) {
                $model->setPassword($model->plainPassword);
            }
            $model->save(false);
            Yii::$app->session->setFlash('success', Yii::t('app', 'User has been saved.'));

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}

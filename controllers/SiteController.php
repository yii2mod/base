<?php

namespace app\controllers;

use app\models\forms\ContactForm;
use app\models\forms\ResetPasswordForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii2mod\rbac\filters\AccessControl;

/**
 * Class SiteController
 *
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'login',
                    'logout',
                    'signup',
                    'request-password-reset',
                    'password-reset',
                    'account',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup', 'request-password-reset', 'password-reset'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'account'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'contact' => ['get', 'post'],
                    'account' => ['get', 'post'],
                    'login' => ['get', 'post'],
                    'logout' => ['post'],
                    'signup' => ['get', 'post'],
                    'request-password-reset' => ['get', 'post'],
                    'password-reset' => ['get', 'post'],
                    'page' => ['get', 'post'],
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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'login' => [
                'class' => 'yii2mod\user\actions\LoginAction',
            ],
            'logout' => [
                'class' => 'yii2mod\user\actions\LogoutAction',
            ],
            'signup' => [
                'class' => 'yii2mod\user\actions\SignupAction',
            ],
            'request-password-reset' => [
                'class' => 'yii2mod\user\actions\RequestPasswordResetAction',
            ],
            'password-reset' => [
                'class' => 'yii2mod\user\actions\PasswordResetAction',
            ],
            'page' => [
                'class' => 'yii2mod\cms\actions\PageAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays contact page.
     *
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'There was an error sending email.'));
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays account page.
     *
     * @return string|\yii\web\Response
     */
    public function actionAccount()
    {
        $resetPasswordForm = new ResetPasswordForm(Yii::$app->user->identity);

        if ($resetPasswordForm->load(Yii::$app->request->post()) && $resetPasswordForm->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Password has been updated.'));

            return $this->refresh();
        }

        return $this->render('account', [
            'resetPasswordForm' => $resetPasswordForm,
        ]);
    }
}

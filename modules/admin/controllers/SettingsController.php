<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;

/**
 * Class SettingController
 * @package app\modules\admin\controllers
 */
class SettingsController extends Controller
{

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'cron' => 'yii2mod\cron\actions\CronLogAction',
        ];
    }

    /**
     * Clear cache
     * @return \yii\web\Response
     */
    public function actionClearCache()
    {
        if (\Yii::$app->cache->flush()) {
            \Yii::$app->session->setFlash('success', 'Cache has been removed.');
            return $this->redirect(\Yii::$app->request->getReferrer());
        }
    }

}

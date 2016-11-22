<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;

/**
 * Class SettingController
 *
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
}

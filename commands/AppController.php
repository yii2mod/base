<?php

namespace app\commands;

use yii2mod\cms\models\CmsModel;
use yii2mod\cms\models\enumerables\CmsStatus;
use yii2tech\sitemap\File;

/**
 * Class AppController
 *
 *  ~~~
 *   php yii app/generate-sitemap
 *  ~~~
 *
 * @package app\commands
 */
class AppController extends BaseController
{
    /**
     * Generate sitemap
     */
    public function actionGenerateSitemap()
    {
        $siteMapFile = new File();
        $siteMapFile->writeUrl(['site/index'], ['priority' => '0.9']);
        $siteMapFile->writeUrl(['site/contact']);
        $pages = CmsModel::find()->where(['status' => CmsStatus::ENABLED])->all();
        foreach ($pages as $page) {
            $siteMapFile->writeUrl([$page->url]);
        }
        $siteMapFile->close();
    }
}
    
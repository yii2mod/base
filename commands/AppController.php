<?php

namespace app\commands;

use Yii;
use yii2mod\cms\models\CmsModel;
use yii2tech\sitemap\File;

/**
 * Class AppController
 *
 * ```php
 * php yii app/generate-sitemap - Sitemap composing
 * php yii app/clear-table User - Delete all data from specific table
 * ```
 *
 * @author Igor Chepurnoy <chepurnoi.igor@gmail.com>
 *
 * @since 1.0
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
        $pages = CmsModel::find()->enabled()->all();
        foreach ($pages as $page) {
            $siteMapFile->writeUrl([$page->url]);
        }

        $siteMapFile->close();

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * Delete all data from specific table
     *
     * @param $tableName
     *
     * @throws \yii\db\Exception
     *
     * @return int
     */
    public function actionClearTable($tableName)
    {
        if ($this->confirm(Yii::t('app', 'Are you sure you want to clear this table?'))) {
            Yii::$app->db->createCommand()->delete($tableName)->execute();
        }

        return self::EXIT_CODE_NORMAL;
    }
}

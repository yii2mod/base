<?php

namespace app\commands;

use app\models\UserModel;
use Yii;
use yii\helpers\Console;
use yii2mod\cms\models\CmsModel;
use yii2mod\cms\models\enumerables\CmsStatus;
use yii2tech\sitemap\File;

/**
 * Class AppController
 *
 *  ~~~
 *   php yii app/generate-sitemap - Sitemap composing
 *   php yii app/clear-table User - Delete all data from specific table
 *   php yii app/assign-role-to-user admin admin@mail.com - Assign role to the user
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

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * Delete all data from specific table
     *
     * @param $tableName
     * @return int
     *
     * @throws \yii\db\Exception
     */
    public function actionClearTable($tableName)
    {
        Yii::$app->db->createCommand()->delete($tableName)->execute();

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * Assign role to the user
     *
     * @param $roleName string user role
     * @param $email string user email
     * @return int
     */
    public function actionAssignRoleToUser($roleName, $email)
    {
        $authManager = Yii::$app->authManager;
        $user = UserModel::findByEmail($email);
        $role = $authManager->getRole($roleName);

        if (empty($user)) {
            $this->stdout("User with `{$email}` does not exists.\n", Console::FG_RED);
            return self::EXIT_CODE_ERROR;
        }

        if (empty($role)) {
            $this->stdout("Role `{$roleName}` does not exists.\n", Console::FG_RED);
            return self::EXIT_CODE_ERROR;
        }

        // Check if role is already assigned to the user
        if (in_array($roleName, array_keys($authManager->getRolesByUser($user->id)))) {
            $this->stdout("Role `{$roleName}` already assigned to this user.\n", Console::FG_BLUE);
            return self::EXIT_CODE_NORMAL;
        }

        $authManager->assign($role, $user->id);

        $this->stdout("The role `{$roleName}` has been successfully assigned to the user with email {$email}\n", Console::FG_YELLOW);

        return self::EXIT_CODE_NORMAL;
    }
}
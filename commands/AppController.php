<?php

namespace app\commands;

use app\models\UserModel;
use Yii;
use yii\console\Exception;
use yii\helpers\Console;
use yii\rbac\Role;
use yii2mod\cms\models\CmsModel;
use yii2tech\sitemap\File;

/**
 * Class AppController
 *
 *  ~~~
 *   php yii app/generate-sitemap - Sitemap composing
 *   php yii app/clear-table User - Delete all data from specific table
 *   php yii app/assign-role-to-user admin admin@example.org - Assign role to the user
 *   php yii app/revoke-role-from-user admin admin@example.org - Revoke role from the user
 *  ~~~
 *
 * @author Igor Chepurnoy <chepurnoi.igor@gmail.com>
 *
 * @since 1.0
 */
class AppController extends BaseController
{
    /**
     * @var \yii\rbac\ManagerInterface
     */
    private $_authManager;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->_authManager = Yii::$app->authManager;
    }

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
        Yii::$app->db->createCommand()->delete($tableName)->execute();

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * Assign role to the user
     *
     * @param string $roleName
     * @param string $email
     *
     * @return int
     */
    public function actionAssignRoleToUser($roleName, $email)
    {
        $user = $this->findUserByEmail($email);
        $role = $this->findRole($roleName);

        if (in_array($roleName, array_keys($this->_authManager->getRolesByUser($user->id)))) {
            $this->stdout("This role already assigned to this user.\n", Console::FG_BLUE);

            return self::EXIT_CODE_NORMAL;
        }

        $this->_authManager->assign($role, $user->id);

        $this->stdout("The role '{$roleName}' has been successfully assigned to the user.\n", Console::FG_BLUE);

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * Revoke role from the user
     *
     * @param string $roleName
     * @param string $email
     *
     * @return int
     *
     * @throws Exception
     */
    public function actionRevokeRoleFromUser($roleName, $email)
    {
        $user = $this->findUserByEmail($email);
        $role = $this->findRole($roleName);

        if (!in_array($roleName, array_keys($this->_authManager->getRolesByUser($user->id)))) {
            throw new Exception('This role is not assigned to this user.');
        }

        $this->_authManager->revoke($role, $user->id);

        $this->stdout("The role '{$roleName}' has been successfully revoked from the user.\n", Console::FG_BLUE);

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * Find user by email
     *
     * @param string $email
     *
     * @return UserModel
     *
     * @throws Exception
     */
    protected function findUserByEmail($email)
    {
        if (($user = UserModel::findByEmail($email)) !== null) {
            return $user;
        }

        throw new Exception("The user with e-mail '{$email}' is not found.");
    }

    /**
     * Returns the named role.
     *
     * @param string $roleName
     *
     * @return Role
     *
     * @throws Exception
     */
    protected function findRole($roleName)
    {
        if (($role = $this->_authManager->getRole($roleName)) !== null) {
            return $role;
        }

        throw new Exception("The role '{$roleName}' is not found.");
    }
}

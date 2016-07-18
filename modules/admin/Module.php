<?php

namespace app\modules\admin;

use yii2mod\rbac\components\AccessControl;

/**
 * Class Module
 * @package app\modules\admin
 */
class Module extends \yii\base\Module
{
    /**
     * @var string the default route of this module. Defaults to 'default'.
     */
    public $defaultRoute = 'user';

    /**
     * @var string|boolean the layout that should be applied for views within this module.
     */
    public $layout = 'column2';

    /**
     * @var string the namespace that controller classes are in.
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            AccessControl::className()
        ];
    }
}
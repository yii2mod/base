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
     * Default route
     * @var string
     */
    public $defaultRoute = 'user';

    /**
     * Default layout
     * @var string
     */
    public $layout = 'column2';

    /**
     * Controller namespace
     * @var string
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     *
     */
    public function init()
    {
        $this->attachBehavior(AccessControl::className(), new AccessControl());
        parent::init();
    }

}

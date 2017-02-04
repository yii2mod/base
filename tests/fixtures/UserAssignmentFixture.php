<?php

namespace app\tests\fixtures;

use Yii;
use yii\test\ActiveFixture;

class UserAssignmentFixture extends ActiveFixture
{
    /**
     * @var string
     */
    public $dataFile = '@tests/_data/user_assignment.php';

    /**
     * @var string
     */
    public $depends = ['app\tests\fixtures\UserFixture'];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->tableName = Yii::$app->authManager->assignmentTable;

        parent::init();
    }
}

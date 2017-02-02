<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    /**
     * @var string
     */
    public $dataFile = '@tests/_data/user.php';

    /**
     * @var string
     */
    public $modelClass = 'app\models\UserModel';
}

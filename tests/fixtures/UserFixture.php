<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    /**
     * @var string
     */
    public $dataFile = '@codecept_data_dir/user.php';

    /**
     * @var string
     */
    public $modelClass = 'app\models\UserModel';
}
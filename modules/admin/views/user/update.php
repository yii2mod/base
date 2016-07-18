<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserModel */

$this->title = Yii::t('user', 'Update User: {0}', $model->username);
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('user', 'Update');
?>
<div class="user-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

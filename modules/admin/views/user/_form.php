<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii2mod\user\models\enumerables\UserStatus;

/* @var $this yii\web\View */
/* @var $model app\models\UserModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'create-user-form']); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

            <?php echo $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

            <?php echo $form->field($model, 'status')->dropDownList(UserStatus::listData()); ?>

            <?php echo $form->field($model, 'newPassword')->passwordInput(['autocomplete' => 'off']); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
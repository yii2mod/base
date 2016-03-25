<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\widgets\DetailView;

/* @var $resetPasswordForm \app\models\forms\ResetPasswordForm */
/* @var $userModel \app\models\UserModel */

$this->title = 'My Account';
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo Yii::t('app', 'Change Password'); ?>
                </div>

                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <?php echo $form->field($resetPasswordForm, 'password')->passwordInput(); ?>
                    <?php echo $form->field($resetPasswordForm, 'confirmPassword')->passwordInput(); ?>
                    <div class="form-group">
                        <?php echo Html::resetButton('Cancel', ['class' => 'btn btn-default']) ?>
                        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading no-bottom-border">
                    <?php echo Yii::t('app', 'Personal Information'); ?>
                </div>
                <div class="table-responsive">
                    <?php echo DetailView::widget([
                        'model' => $userModel,
                        'attributes' => [
                            "username",
                            "email",
                            'lastLogin:date'
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>

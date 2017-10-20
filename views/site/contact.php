<?php

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\ContactForm */

$this->title = Yii::t('contact', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?php echo Html::encode($this->title); ?></h1>
    <p>
        <?php echo Yii::t('contact', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.'); ?>
    </p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
            <?php echo $form->field($model, 'name'); ?>
            <?php echo $form->field($model, 'email'); ?>
            <?php echo $form->field($model, 'subject'); ?>
            <?php echo $form->field($model, 'body')->textArea(['rows' => 6]); ?>
            <?php echo $form->field($model, 'verifyCode')->widget(Captcha::class, [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]); ?>
            <div class="form-group">
                <?php echo Html::submitButton(Yii::t('contact', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

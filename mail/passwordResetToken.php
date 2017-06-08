<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \app\models\UserModel */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/password-reset', 'token' => $user->password_reset_token]);
?>

Hello <?php echo Html::encode($user->username) ?>,

Follow the link below to reset your password:

<?php echo Html::a(Html::encode($resetLink), $resetLink) ?>

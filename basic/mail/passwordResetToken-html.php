<?php

use yii\helpers\Html;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['autoshop/reset-password', 'token' => $user->password_reset_token]);
?>

<div class="password-reset">
    <p> <?= Html::encode($user->FName) ?>,</p>
    <p>Перейдите по ссылке, что бы сбросить пароль:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
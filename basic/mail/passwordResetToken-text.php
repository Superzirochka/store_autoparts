<?php
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['autoshop/reset-password', 'token' => $user->password_reset_token]);
?>

<?= $user->FName ?>,
Перейдите по ссылке, что бы сбросить пароль:

<?= $resetLink ?>
<?php

use yii\helpers\Html;
?>
<p><strong>Имя</strong>: <?= Html::encode($name); ?></p>
<p><strong>Email</strong>: <?= Html::encode($email); ?></p>
<p><strong>Сообщение</strong>:</p>
<p><?= nl2br(Html::encode($body)); ?></p>
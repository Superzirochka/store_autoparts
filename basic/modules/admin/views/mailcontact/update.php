<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\MailContact */

$this->title = Yii::t('app', 'Редактирование сообщения от: {name}', [
    'name' => $model->FIO,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Сообщения'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Сообщение №' . $model->Id . ' дата: ' . $model->DateAdd, 'url' => ['view', 'id' => $model->Id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактирование');
?>
<div class="mail-contact-update">
<div class="d-flex justify-content-between">
    <h2><?= Html::encode($this->title) ?></h2>
    <a class="btn mt-3" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <?= $this->render('_formanswer', [
        'answer' => $answer,
    ]) ?>

</div>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\MailContact */
/* @var $form yii\widgets\ActiveForm */

$items = [
    'new' => 'Новый',
    'processed' => 'В работе',
    'considered' => 'Рассмотрен',
    'completed' => 'Завершен',
    'delete' => 'Удален',
];
?>

<div class="mail-contact-form">

    <?php $form = ActiveForm::begin(
        ['id' => $model->Id]
    ); ?>

    <?= $form->field($model, 'FIO')->textInput(['maxlength' => true, 'disabled' => "disabled"]) ?>

    <?= $form->field($model, 'TitleMessage')->textInput(['maxlength' => true, 'disabled' => "disabled"]) ?>

    <?= $form->field($model, 'Message')->textarea(['disabled' => "disabled"]) ?>

    <?= $form->field($model, 'Email')->textInput(['maxlength' => true, 'disabled' => "disabled"]) ?>

    <?= $form->field($model, 'Status')->dropDownList($items)
    //textInput(['maxlength' => true]) 
    ?>

    <?= $form->field($model, 'DateAdd')->textInput(['disabled' => "disabled"]) ?>

    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
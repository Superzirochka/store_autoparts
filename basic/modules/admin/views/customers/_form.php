<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\models\GpuopCustomers;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Customers */
/* @var $form yii\widgets\ActiveForm */

$mailing = [
    1 => 'Подписан на рассылку',
    0 => 'отказ от рассылки'
];

$items = [
    '10' => 'Активный',
    '0' => 'Удален',

];




?>

<div class="customers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Login')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'FName')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'LName')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'Email')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'Phone')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'News')->dropDownList($mailing,  ['disabled' => 'disabled']) ?>

    <?= $form->field($model, 'City')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Adres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdGruop')->dropDownList(
        GpuopCustomers::find()->select(['Name', 'Id'])->indexBy('Id')->orderBy('Name ASC')->column()
    ) ?>



    <?= $form->field($model, 'Status')->dropDownList([$items], ['disabled' => 'disabled']) ?>

    <?= $form->field($model, 'DateRegistration')->textInput(['readonly' => true]) ?>

    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
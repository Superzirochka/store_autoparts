<?php

use yii\helpers\Url;
use app\modules\admin\models\Dostavka;
use app\modules\admin\models\Oplata;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\OrdersShop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-shop-form">

    <?php $form = ActiveForm::begin(); ?>
    <?
    $items = [
        'new' => 'Новый',
     'processed' => 'Обработан',
        'paid' => 'Оплачен',
        'delivered' => 'Доставлен',
        'completed' => 'Завершен',
    ];

    $mailing = [
1 =>'Подписан на рассылку',
0=>'отказ от рассылки'
    ];
    ?>
    <div class="form-row">

        <div class="col-md-3 mb-3">
            <?= $form->field($model, 'Status')->dropDownList($items) ?>
        </div>
        <div class="col-md-3 mb-3">
            <?= $form->field($model, 'OrderNumber')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
        <div class="col-md-3 mb-3">
            <?= $form->field($model, 'DateAdd')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-3 mb-3">
            <?= $form->field($model, 'Amount')->textInput(['readonly' => true]) ?>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <fieldset>
                <legend>Контактная информация</legend>
                <?= $form->field($model, 'Name')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                <?= $form->field($model, 'LastName')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                <?= $form->field($model, 'Email')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                <?= $form->field($model, 'Phone')->textInput(['maxlength' => true, 'readonly' => true]) ?>
            </fieldset>
        </div>
        <div class="col-md-4 mb-3">
            <fieldset>
                <legend>Доставка</legend>
                <?= $form->field($model, 'IdDostavka')->dropdownList(
                    Dostavka::find()->select(['Name', 'Id'])->indexBy('Id')->orderBy('Name ASC')->column(),
                    ['disabled' => 'disabled']
                ) ?>
                <?= $form->field($model, 'City')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                <?= $form->field($model, 'Adress')->textInput(['maxlength' => true, 'readonly' => true]) ?>
            </fieldset>
        </div>
        <div class="col-md-4 mb-3">
            <fieldset>
                <legend>Оплата</legend>
                <?= $form->field($model, 'IdOplata')->dropdownList(
                    Oplata::find()->select(['Name', 'Id'])->indexBy('Id')->orderBy('Name ASC')->column(),
                    ['disabled' => 'disabled']
                ) ?>
            </fieldset>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-8 mb-3">
            <?= $form->field($model, 'Comment')->textArea(['maxlength' => true, 'readonly' => true]) ?>

        </div>
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'Mailing')->dropDownList($mailing)  ?>
        </div>
    </div>

    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
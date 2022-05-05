<?php

use app\modules\admin\models\Engine;
use app\modules\admin\models\ModelAuto;
use app\modules\admin\models\ValueEngine;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ManufacturerAuto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="manufacturer-auto-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-row">
        <div class="col-md-12 mb-4">
            <?//= $form->field($model, 'IdModelAuto')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'IdModelAuto')->dropdownList(
                ModelAuto::find()->select(['ModelName', 'Id'])->indexBy('Id')->orderBy('ModelName ASC')->column(),
                ['disabled' => 'disabled']
            ) ?>
            <?= $form->field($model, 'IdEngine')->dropdownList(
                Engine::find()->select(['Name', 'Id'])->indexBy('Id')->orderBy('Name ASC')->column()
            ) ?>
            <?= $form->field($model, 'IdValueEngine')->dropdownList(
                ValueEngine::find()->select(['Value', 'Id'])->indexBy('Id')->orderBy('Value ASC')->column()
            ) ?>
        </div>
    </div>
    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
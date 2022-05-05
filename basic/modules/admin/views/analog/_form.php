<?php

use app\modules\admin\models\ManufacturerAuto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BrandProd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-prod-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'Marka')->
        //textInput() 
        dropdownList(
            ManufacturerAuto::find()->select('Marka, Id')->indexBy('Id')->orderBy('Marka ASC')->column()
            //find()->select('Node, Id')->indexBy('Id')->orderBy('Node ASC')->column()
            // $parentNode
        )
    ?>
    <?= $form->field($model, 'OEM')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Analog')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Brand')->textInput(['maxlength' => true]) ?>

    <div class="form-group d-flex justify-content-around mt-3">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
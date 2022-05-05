<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Kurs */
/* @var $form ActiveForm */
?>
<div class="kursform">
    <?php $form = ActiveForm::begin([
        'action' => 'index'
    ]); ?>

    <div class="form-group row">
        <div class="col-sm-6"><?= $form->field($model, 'Current_kurs')->textInput(['type' => 'number', 'step' => "0.01"]) ?></div>
        <div class="col-sm-6 mt-2">
            <?= Html::submitButton(Yii::t('app', 'Обновить'), ['class' => 'btn btn-primary mt-4 ']) ?></div>




    </div>
    <?php ActiveForm::end(); ?>

</div><!-- _kursform -->
<?php

use app\modules\admin\models\ManufacturerAuto;
use app\modules\admin\models\ModelAuto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Zakaz */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zakaz-form">
    <?
    $items = [
        'new' => 'Новый',
        'processed' => 'В обработке',       
        'completed' => 'Завершен',
        'delete'=> 'Удален',
    ];?>

    <? 
    Pjax::begin([
    // Опции Pjax
]);
     $form = ActiveForm::begin([
        'options' => ['method' => 'POST','data' => ['pjax' => true]],
     ]); ?>

    <?= $form->field($model, 'MarkaAuto')->textInput(
        [
            'disabled' => "disabled"
        ]
    )
    ?>
    <?
    $js = <<<JS
    $('#markaAuto').on('change', function(){
        var data = $(this).val();
        $.ajax({
            url: 'ajax',
            type: 'GET',
            //dataType: 'json',
            data: {'data':data},//{data: data},
            success: function(res){
               $('#modelsAuto').html(res);
                console.log(res);
            },
            error: function(){
                alert('Error!');
            }
        });
        return false;
    });
JS;

    $this->registerJs($js);
    ?>



    <?= $form->field($model, 'ModelAuto')->textInput(
        [
            'disabled' => "disabled"
        ]
    )
    ?>

    <?= $form->field($model, 'YearCon')->textInput(['disabled' => "disabled"]) ?>

    <?= $form->field($model, 'ValueEngine')->textInput(['disabled' => "disabled"]) ?>

    <?= $form->field($model, 'VIN')->textInput(['disabled' => "disabled"]) ?>

    <?= $form->field($model, 'Description')->textInput(['disabled' => "disabled"]) ?>

    <?= $form->field($model, 'FIO')->textInput(['disabled' => "disabled"]) ?>

    <?= $form->field($model, 'Email')->textInput(['disabled' => "disabled"]) ?>

    <?= $form->field($model, 'Phone')->textInput(['disabled' => "disabled"]) ?>

    <?= $form->field($model, 'DateAdd')->textInput(['disabled' => "disabled"]) ?>

    <?= $form->field($model, 'Status')->dropDownList($items) ?>

    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end();

    Pjax::end();
    ?>

</div>
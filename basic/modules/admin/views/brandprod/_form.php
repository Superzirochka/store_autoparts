<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BrandProd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-prod-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'Brand')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'Img')->textInput(['maxlength' => true,  'id' => 'ImgBrand']) ?>
    <fieldset>

        <div class="row">
            <div class="col-sm-6">
                <legend>Загрузить изображение</legend>
                <?= $form->field($model, 'imageFile')->fileInput([
                    'id' => 'imgFile'
                ]); ?>
            </div>
            <div class="col-sm-6">
                <?php
                if (!empty($model->Img)) {
                    $img = Yii::getAlias('@webroot') . '/img/' . $model->Img;
                    if (is_file($img)) {
                        $url = Yii::getAlias('@web') . '/img/' . $model->Img;
                        echo 'Уже загружено<br>';
                        echo Html::img('@web/img/' . $model->Img, ['alt' => $model->Brand, 'class' => 'img adminBrend rounded mx-auto d-bloc']) . '<br>';
                        echo 'имя файла: ' . $model->Img;

                        //  echo $form->field($model, 'remove')->checkbox();
                    }
                }

 
                ?>
            </div>
        </div>






        <?
    $js = <<<JS
    $('#imgFile').on('change', function(){
        var data = $(this).val();
        $.ajax({
            url: 'ajax',
            type: 'GET',
            //dataType: 'json',
            data: {'data':data},//{data: data},
            success: function(res){
               //$('#ImgBrand').html(res);
                console.log(data);
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
    </fieldset>
    <div class="form-group d-flex justify-content-around mt-3">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
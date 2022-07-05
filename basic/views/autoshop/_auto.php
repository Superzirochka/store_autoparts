<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\ManufacturerAuto;
use app\models\BannerImg;
use app\models\ModelAuto;
use app\models\Modification;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$autobrend = ManufacturerAuto::find()->select('Id, Marka, Img, link')->all();
$autobrend = ManufacturerAuto::find()->select('Id, Marka, Img, link')->all();
$modif = Modification::find()->select(['IdModelAuto', 'IdEngine', 'IdValueEngine', 'Id'])->indexBy('Id')->all();
$textModif = ['-'];

?>
<div class="col-sm-12">
    <? Pjax::begin([
        // Опции Pjax
    ]) ?>
    <?php $form = ActiveForm::begin([
        'action' => 'index',
        'options' => [
            'class' => ' ', 'id' => 'autoForm', 'method' => 'POST', 'data' => ['pjax' => true] //, 'autofocus' => true
        ]
    ]) ?>
    <div class="form-row">
        <div class="col-md-3 ">
            <? // var_dump($id) 
            ?>
            <? if (!empty($id)) : ?>
                <? $m = ManufacturerAuto::find()->select(['Marka', 'Id'])->where(['Id' => $id])->one();
                $markaOne = [$m->Id => $m->Marka];
                // $markaOne[]
                ?>
                <?= $form->field($model, 'marka')->dropDownList(
                    $markaOne,
                    //ManufacturerAuto::find()->select(['Marka', 'Id'])->where(['Id' => $id])->column(),
                    ['id' => 'marka', 'class' => 'form-control']
                ); ?>
            <? else : ?>
                <?= $form->field($model, 'marka')->dropDownList(
                    ManufacturerAuto::find()->select(['Marka', 'Id'])->indexBy('Id')->column(),
                    [
                        'prompt' => 'Оберіть марку автомобіля',  'id' => 'marka', 'class' => 'form-control', 'autofocus' => true
                    ]
                ); ?>

            <? endif ?>

            <?php
            $js = <<<JS
    $('#marka').on('change', function(){
        let data = $(this).val();
        $.ajax({
            url: '/autocatalog/index',//'zakaz',
            type: 'GET',
          //  dataType : 'json',
            data:{'data' : data},
            
            success: function(res){
                $("#model").html(res);
                $("#modif").html('<option>-</option>');
                $("#model").focus();
                console.log(res);
            },
            error: function(){
                //let statusCode = request.status;
                console.log('Error!'+data);
            }
        });
        return false;
    });
JS;

            $this->registerJs($js);
            ?>

        </div>
        <div class="col-md-3">
            <? if (!empty($id)) : ?>
                <?= $form->field($model, 'model')->dropDownList(

                    ModelAuto::find()->select(['ModelName', 'Id'])->where(['IdManufacturer' => $id])->indexBy('Id')->column(),
                    [
                        'prompt' => 'Оберіть...',
                        'id' => 'model'

                    ]
                ) ?>
            <? else : ?>
                <?= $form->field($model, 'model')->dropDownList(
                    $textModif,
                    // ModelAuto::find()->select(['ModelName', 'Id'])->indexBy('Id')->column(),
                    [
                        'prompt' => 'Оберіть...',
                        'id' => 'model'

                    ]
                ) ?>
            <? endif ?>
            <?php
            $js = <<<JS
    $('#model').on('change', function(){
        let data = $(this).val();
        $.ajax({
            url: '/autocatalog/index',
            type: 'GET',
          //  dataType : 'json',
            data:{'model' : data},
            
            success: function(res){
                $("#modif").html(res);
                $("#modif").focus();
                console.log(res);
            },
            error: function(){
                //let statusCode = request.status;
                console.log('Error!'+res);
            }
        });
        return false;
    });
JS;

            $this->registerJs($js);
            ?>
        </div>
        <div class="col-md-3 ">

            <?= $form->field($model, 'modification')->dropDownList(
                $textModif,
                [
                    'prompt' => 'Оберіть...',
                    'id' => 'modif'

                ]
            ) ?>



        </div>
        <div class="col-md-3 mt-4 ml-0">
            <?
            if (!empty($id)) :
            ?>
                <?= Html::submitButton(Yii::t('app', 'ОК'), ['class' => 'btn w-50 mt-2 ml-5',  'id' => 'myBackgra']) ?>

                <!-- <a href="<?= yii\helpers\Url::to(['autocatalog/index', 'marka' => $model->marka, 'models' => $model->model, 'modification' => $model->modification]) ?>" class="btn w-25 mt-2" id="myBackgra">OK</a> -->
            <? else : ?>
                <?= Html::submitButton(Yii::t('app', 'ОК'), ['class' => 'btn w-50 mt-2 ml-5',  'id' => 'myBackgra']) ?>
                <!-- <a href="<?= yii\helpers\Url::to(['autocatalog/index', 'marka' => $model->marka, 'models' => $model->model, 'modification' => $model->modification]) ?>" class="btn w-25 mt-2" id="myBackgra">OK</a> -->
            <? endif ?>
        </div>

    </div>





    <?php ActiveForm::end() ?>
    <? Pjax::end(); ?>
</div>
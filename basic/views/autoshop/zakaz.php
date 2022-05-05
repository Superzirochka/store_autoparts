<?php
/* @var $this yii\web\View */

use app\models\Engine;
use app\models\ManufacturerAuto;
use app\models\ModelAuto;
use app\models\ValueEngine;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

$lang = Yii::$app->session->get('lang');
$Id_lang = $lang['Id'];
$years = [
    '1985' => 1985,
    '1986' => 1986,
    '1987' => 1987,
    '1988' => 1988,
    '1989' => 1989,
    '1990' =>  1990,
    '1991' =>  1991,
    '1992' =>  1992,
    '1993' => 1993,
    '1994' => 1994,
    '1995' => 1995,
    '1996' => 1996,
    '1997' => 1997,
    '1998' => 1998,
    '1999' => 1999,
    '2000' => 2000,
    '2001' => 2001,
    '2002' => 2002,
    '2003' => 2003,
    '2004' => 2004,
    '2005' => 2005,
    '2006' => 2006,
    '2007' => 2007,
    '2008' => 2008,
    '2009' => 2009,
    '2010' => 2010,
    '2011' => 2011,
    '2012' => 2012,
    '2013' => 2013,
    '2014' => 2014,
    '2015' => 2015,
    '2016' => 2016,
    '2017' => 2017,
    '2018' => 2018,
    '2019' => 2019,
    '2020' => 2020,
];
?>
<div class="container" id="content_box">


    <div class="form pt-2 pb-2">
        <?php if (!empty($answer)) : ?>
            <p><code>Данные приняты</code></p>
        <?php endif; ?>
        <? Pjax::begin([
    // Опции Pjax
])?>
        <?php $form = ActiveForm::begin(['options' => ['class' => 'needs-validation my-shadow mt-1 mb-1', 'method' => 'POST', 'novalidate' => true, 'data' => ['pjax' => true]]]) ?>

        <fieldset>
            <legend>Форма заказа</legend>
            <p><b class="text-danger">*</b> поля обязательные для заполнения</p>
            <fieldset>
                <legend>Информация об автомобиле</legend>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <?= $form->field($zakaz_form, 'marka')->dropDownList(
                            $markaArr,
                            ['prompt' => 'Выберите марку автомобиля',  'id' => 'marka', 'class' => 'form-control']
                        )->label('Марка Автомобиля'); ?>

                        <?php
                        $js = <<<JS
    $('#marka').on('change', function(){
        let data = $(this).val();
        $.ajax({
            url: 'zakaz',
            type: 'GET',
          //  dataType : 'json',
            data:{'data' : data},
            
            success: function(res){
                $("#model").html(res)
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


                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">


                        <?= $form->field($zakaz_form, 'model')->dropDownList(

                            ModelAuto::find()->select(['ModelName', 'Id'])->indexBy('Id')->column(),
                            [
                                'prompt' => 'Выберите...',
                                'id' => 'model'

                            ]
                        )->label('Модель Автомобиля'); ?>


                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <?= $form->field($zakaz_form, 'years')->
                            //textInput(['type' => 'month'])

                            dropdownList($years)
                        //     ModelAuto::find()->select(['constructioninterval', 'Id'])->indexBy('Id')->orderBy('constructioninterval ASC')->column(),
                        //     ['prompt' => 'Выберите модель автомобиля',  'id' => 'years', 'class' => 'form-control']
                        // )->label('Год выпуска'); 
                        ?>


                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <?= $form->field($zakaz_form, 'volume')->dropdownList(
                            ValueEngine::find()->select(['Value', 'Id'])->indexBy('Id')->orderBy('Value ASC')->column(),
                            ['prompt' => 'Выберите oбъем двигателя',  'id' => 'volume', 'class' => 'form-control']
                        )->label('Объем двигателя'); ?>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <?= $form->field($zakaz_form, 'eng')->dropdownList(
                            Engine::find()->select(['Name', 'Id', 'Id_lang'])->where(['Id_lang' => $Id_lang])->indexBy('Id')->column(),
                            ['prompt' => 'Выберите вид топлива',  'id' => 'eng', 'class' => 'form-control']
                        )->label('Топливо'); ?>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <?= $form->field($zakaz_form, 'vin')->textInput(['placeholder' => '124f856rth9647', 'type' => 'text', 'id' => 'vin', 'class' => 'form-control'])->label('VIN код'); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <?= $form->field($zakaz_form, 'description')->textArea(['placeholder' => 'Перезвоните мне пожалуйста', 'cols' => '30', 'rows' => '10', 'id' => 'zakaz', 'class' => 'form-control'])->label('Какая запчасть интересует'); ?>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

                </div>

            </fieldset>

            <fieldset>
                <legend>Контактная информация</legend>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <?= $form->field($zakaz_form, 'fio')->textInput(['placeholder' => 'Иван Сидорович', 'id' => 'fio', 'class' => 'form-control'])->label('ФИО'); ?>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <?= $form->field($zakaz_form, 'phone')->textInput(['placeholder' => '+38(057)123-45-67', 'type' => 'tel', 'id' => 'phone', 'class' => 'form-control'])->label('Номер телефона'); ?>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <?= $form->field($zakaz_form, 'email')->textInput(['placeholder' => 'adres@i.ua', 'type' => 'email', 'id' => 'mail', 'class' => 'form-control'])->label('Email'); ?>

                    </div>
                </div>

            </fieldset>

            <div class="form-row mt-2">
                <div class="col-md-6 mb-3">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary  btn_form']) ?>

                </div>
                <div class="col-md-6 mb-3">
                    <a href="<?= Url::home() ?>" class="btn btn-primary btn_form">Oтмена</a>
                </div>
            </div>

        </fieldset>
        <?php ActiveForm::end() ?>
        <? Pjax::end();?>
    </div>


</div>
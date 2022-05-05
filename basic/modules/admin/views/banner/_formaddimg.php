<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\models\Banner;
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Banner */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="banner-formADD">

    <?php $form = ActiveForm::begin([
        'id' => $model->Id . 'ADD'
    ]); ?>

    <?= $form->field($model, 'IdBanner')->dropdownList(
        Banner::find()->select(['Name', 'Id'])->indexBy('Id')->orderBy('Name ASC')->column()
    ) ?>
    <div class="row">
        <div class="col-sm-6">
            <legend>Загрузить изображение</legend>
            <?= $form->field($model, 'imageFile')->fileInput([
                'id' => 'imgFile' . $model->Id
            ]); ?>
        </div>
        <div class="col-sm-6">
            <?php
            if (!empty($model->Img)) {
                $img = Yii::getAlias('@webroot') . '/img/' . $model->Img;
                if (is_file($img)) {
                    $url = Yii::getAlias('@web') . '/img/' . $model->Img;
                    echo 'Уже загружено<br>';
                    echo Html::img('@web/img/' . $model->Img, ['alt' => 'слайдер изображение', 'class' => 'img adminBrend rounded mx-auto d-bloc']) . '<br>';
                    echo 'имя файла: ' . $model->Img;

                    //  echo $form->field($model, 'remove')->checkbox();
                }
            }
            ?>
        </div>
    </div>

    <?= $form->field($model, 'Title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Link')->textInput() ?>


    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
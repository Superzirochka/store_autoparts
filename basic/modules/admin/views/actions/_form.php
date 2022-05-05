<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Actions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="actions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'Slug')->textInput(['maxlength' => true]) ?>
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
                    echo Html::img($url, ['alt' => 'слайдер изображение', 'class' => 'img adminBrend rounded mx-auto d-bloc']) . '<br>';
                    echo 'имя файла: ' . $model->Img;

                    //  echo $form->field($model, 'remove')->checkbox();
                }
            }
            ?>
        </div>
    </div>

    <?= $form->field($model, 'Content')->widget(
        CKEditor::class,
        [
            'editorOptions' => [
                // разработанны стандартные настройки basic, standard, full
                'preset' => 'full',
                'inline' => false, // по умолчанию false
            ],
        ]
    ); ?>

    <?//= $form->field($model, 'Img')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'KeyWord')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MetaDescription')->textInput(['maxlength' => true]) ?>

    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
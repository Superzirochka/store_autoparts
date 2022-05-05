<?php

use app\modules\admin\models\NodeAuto;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ManufacturerAuto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="manufacturer-auto-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-row">
        <div class="col-md-6 mb-4">

            <fieldset>
                <legend>Изображение</legend>
                <?= $form->field($model, 'imageFile')->fileInput([
                    'id' => 'Img'
                ]); ?>

                <?php
                if (!empty($model->Img)) {
                    $img = Yii::getAlias('@webroot') . '/img/' .  $model->Img;
                    if (is_file($img)) {
                        $url = Yii::getAlias('@web') . '/img/' .  $model->Img;
                        echo 'Уже загружено ', Html::img('@web/img/' . $model->Img, ['alt' => 'Marka', 'class' => 'img adminBrend rounded mx-auto d-bloc']);
                    }
                }
                ?>
            </fieldset>

        </div>
        <div class="col-md-6 mb-4">
            <?= $form->field($model, 'OEM')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'IdNode')->dropdownList(
                NodeAuto::getTree()
            )
            ?>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12 mb-4">
            <?=
                $form->field($model, 'Description')->widget(
                    CKEditor::class,
                    [
                        'editorOptions' => [
                            // разработанны стандартные настройки basic, standard, full
                            'preset' => 'full',
                            'inline' => false, // по умолчанию false
                        ],
                    ]
                );
            ?>
            <?=
                $form->field($model, 'Description_ua')->widget(
                    CKEditor::class,
                    [
                        'editorOptions' => [
                            // разработанны стандартные настройки basic, standard, full
                            'preset' => 'full',
                            'inline' => false, // по умолчанию false
                        ],
                    ]
                );
            ?>
        </div>
    </div>

    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
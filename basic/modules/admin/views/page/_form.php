<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use app\modules\admin\models\Page;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form ml-3">

    <?php $form = ActiveForm::begin(); ?>
    <div class='row'>
        <div class="col-sm-6">
            <?
    // при редактировании существующей страницы нельзя допустить,
    // чтобы в качестве родителя была выбрана эта же страница
    $exclude = 0;
    if (!empty($model->Id)) {
        $exclude = $model->Id;
    }
    
    ?>
            <?= $form->field($model, 'parent_id')->dropDownList(Page::getRootPages($exclude))
            // $form->field($model, 'parent_id')->textInput() 
            ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'Slug')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="ru-tab" data-toggle="tab" href="#ru" role="tab" aria-controls="ru" aria-selected="true">Русский </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ua-tab" data-toggle="tab" href="#ua" role="tab" aria-controls="ua" aria-selected="false">Українська</a>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="ru" role="tabpanel" aria-labelledby="ru-tab">
            <?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'Content')->widget(
                // CKEditor::class,
                // [
                //     'editorOptions' => [
                //         // разработанны стандартные настройки basic, standard, full
                //         'preset' => 'full',
                //         'inline' => false, // по умолчанию false
                //     ],
                // ]    
                CKEditor::class,
                [
                    'editorOptions' => ElFinder::ckeditorOptions(
                        'elfinder',
                        [
                            // разработанны стандартные настройки basic, standard, full
                            'preset' => 'full',
                            'inline' => false, // по умолчанию false
                        ]
                    ),
                ]
            );
            ?>
            <?= $form->field($model, 'Keywords')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="tab-pane fade" id="ua" role="tabpanel" aria-labelledby="ua-tab">
            <?= $form->field($model, 'Name_ua')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'Content_ua')->widget(
                CKEditor::class,
                [
                    'editorOptions' => [
                        // разработанны стандартные настройки basic, standard, full
                        'preset' => 'full',
                        'inline' => false, // по умолчанию false
                    ],
                ]
            );    ?>
            <?= $form->field($model, 'Keywords_ua')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'Description_ua')->textInput(['maxlength' => true]) ?>
        </div>

    </div>


    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
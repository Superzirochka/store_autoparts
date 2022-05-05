<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\MailContact */
/* @var $form yii\widgets\ActiveForm */

$items = [
    'new' => 'Новый',
    'processed' => 'В работе',
    'considered' => 'Рассмотрен',
    'completed' => 'Завершен',
    'delete' => 'Удален',
];
?>

<div class="mail-contact-form">

    <?php $form = ActiveForm::begin([
        'id' => 'answer' . $answer->IdMailContakt
    ]); ?>

    <?//= $form->field($answer, 'IdMailContakt')->textInput(['maxlength' => true, 'disabled' => "disabled"]) ?>

    <?= $form->field($answer, 'Title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($answer, 'Text')->widget(
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
    ); ?>

    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-success w-25']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
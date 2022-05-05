<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\models\Menu;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>
    <?
    // при редактировании существующей страницы нельзя допустить,
    // чтобы в качестве родителя была выбрана эта же страница
    $exclude = 0;
    if (!empty($model->Id)) {
        $exclude = $model->Id;
    }
    echo $form->field($model, 'Id_parentMenu')->dropDownList(Menu::getRootPages($exclude));
    ?>
    <?= $form->field($model, 'NameMenu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NameMenu_ua')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Title_ua')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Sort')->textInput() ?>

    <?= $form->field($model, 'Content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Id_lang')->textInput() ?>


    <?//= $form->field($model, 'Id_parentMenu')->textInput() ?>

    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
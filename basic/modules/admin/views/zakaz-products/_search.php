<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ZakazProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zakaz-products-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Id') ?>

    <?= $form->field($model, 'Supplier') ?>

    <?= $form->field($model, 'Brand') ?>

    <?= $form->field($model, 'ProductName') ?>

    <?= $form->field($model, 'Description') ?>

    <?php // echo $form->field($model, 'EntryPrice') 
    ?>

    <?php // echo $form->field($model, 'Markup') 
    ?>

    <?php // echo $form->field($model, 'Price') 
    ?>

    <?php // echo $form->field($model, 'TermsDelive') 
    ?>

    <?php // echo $form->field($model, 'Img') 
    ?>

    <?php // echo $form->field($model, 'Count') 
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Поиск'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Сброс'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
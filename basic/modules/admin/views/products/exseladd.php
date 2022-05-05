<?php

use mihaildev\ckeditor\CKEditor;


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\modules\admin\models\Products;
use app\modules\admin\models\BrandProd;

$this->title = 'Загрузка товаров';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Товары'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$parents = Products::getTree();
?>
<div class="excels-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <? 
   // Pjax::begin([
    // Опции Pjax
//]); ?>
    <?php $form = ActiveForm::begin(
        ['options' => [
            'enctype' => 'multipart/form-data',
            'method' => 'POST',
            // 'data' => ['pjax' => true]
        ]]
    ); ?>
    <div class="form-group row mt-3 ml-5 mb-3">
        <?= $form->field($model, 'file')->fileInput() ?>

    </div>
    <div class="form-group row mt-3 ml-5 mb-3">
        <?= $form->field($model, 'category')->dropDownList($parents) ?>
    </div>
    <div class="form-group row mt-3 ml-5 mb-3">
        <?= $form->field($model, 'brand')->dropDownList(
            BrandProd::find()->select(['Brand', 'Id'])->indexBy('Id')->orderBy('Brand ASC')->column()
        ) ?>
    </div>
    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Загрузить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>
    <div id='rez'>

    </div>

    <?php ActiveForm::end();
    // Pjax::end();
    ?>

</div>
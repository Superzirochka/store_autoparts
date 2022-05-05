<?php

use mihaildev\ckeditor\CKEditor;
use app\modules\admin\models\BrandProd;
use app\modules\admin\models\Category;
use app\modules\admin\models\Current;
use app\modules\admin\models\Discont;
use app\modules\admin\models\Lang;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\imagine\Image;
use app\modules\admin\models\Products;
//$parents = $model::getTree();
$items = [
    '10' => 'Активный',
    '0' => 'Удален',

];
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">


    <?php $form = ActiveForm::begin(
        [
            'options' => ['method' => 'POST'],
        ]
    ); ?>
    <div class="form-row">
        <div class="col-md-6 mb-4">



        </div>
        <div class="col-md-6 mb-4">
        </div>
    </div>
    <?= $form->field($model, 'Id_recomend')->dropDownList(Products::find()->select(['Name', 'Id'])->indexBy('Id')->orderBy('Name ASC')->column()) ?>


    <?//= $form->field($model, 'Id_category')->dropdownList($parents
        // Category::find()->select(['Name', 'Id'])->indexBy('Id')->orderBy('Name ASC')->column()
   // ) ?>



    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end();
    ?>

</div>
<?php

use app\modules\admin\models\Category;
use app\modules\admin\models\Lang;
use app\modules\admin\models\NodeAuto;
use SebastianBergmann\CodeCoverage\Report\Xml\Node;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// $node =  NodeAuto::find()->all();
// //indexBy('Id')->orderBy('Node ASC')->column();
$parents = $model::getTree();
//$parentNode = $node::getTree();
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">



    <?php $form = ActiveForm::begin([
        'id' => 'create',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'Id_lang')->dropdownList(
                Lang::find()->select(['language', 'Id'])->indexBy('Id')->orderBy('language ASC')->column()
            ) ?>
        </div>
        <div class="col-md-6 mb-3">
            <fieldset>
                <legend>Загрузить изображение</legend>
                <?= $form->field($model, 'imageFile')->fileInput(); ?>
                <?php
                if (!empty($model->Img)) {
                    $img = Yii::getAlias('@webroot') . '/img/' . $model->Img;
                    if (is_file($img)) {
                        $url = Yii::getAlias('@web') . '/img/category/' . $model->Img;
                        echo 'Уже загружено ', Html::img('@web/img/' . $model->Img, ['alt' => 'Product', 'class' => 'img adminBrend rounded mx-auto d-bloc']);
                    }
                }
                ?>
            </fieldset>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">

            <?= $form->field($model, 'Id_parentCategory')
                ->dropdownList($parents)
            ?>
        </div>
        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'id_node')->
                //textInput() 
                dropdownList(
                    NodeAuto::getTree()
                    //find()->select('Node, Id')->indexBy('Id')->orderBy('Node ASC')->column()
                    // $parentNode
                )
            ?>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'MetaTitle')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'MetaDescription')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'MetaKeyword')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
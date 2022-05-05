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
use yii\widgets\Pjax;
use app\modules\admin\models\Kurs;

$currentKurs = Kurs::find()->where(['Id' => 1])->one();


$parents = $model::getTree();
$items = [
    '10' => 'Активный',
    '0' => 'Удален',

];

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Products */
/* @var $form yii\widgets\ActiveForm */

$session = Yii::$app->session;
$session->open();
if ($session->has('kurs')) {
    $kurs = $session->get('kurs');
} else {
    $session->set('kurs', ['kurs' => $currentKurs->Current_kurs]);
}


?>

<div class="products-form">

    <? 
    Pjax::begin([
    // Опции Pjax
]); ?>

    <?php $form = ActiveForm::begin(
        [
            'options' => ['method' => 'POST', 'data' => ['pjax' => true]],
        ]
    ); ?>

    <div class="form-row">
        <div class="col-md-6 mb-4">
            <!-- <?= $form->field($model, 'Img')->textInput(['maxlength' => true]) ?> -->
            <fieldset>
                <legend>Основное изображение</legend>
                <?= $form->field($model, 'imageFile1')->fileInput([
                    'id' => 'Img1'
                ]); ?>


                <?php
                if (!empty($model->Img)) {
                    $img = Yii::getAlias('@webroot') . '/img/' .  $model->Img;
                    if (is_file($img)) {
                        $url = Yii::getAlias('@web') . '/img/' .  $model->Img;
                        echo 'Уже загружено ', Html::img('@web/img/' . $model->Img, ['alt' => 'Product', 'class' => 'img adminBrend rounded mx-auto d-bloc']);
                        // echo $form->field($model, 'remove')->checkbox();
                    }
                }
                ?>
            </fieldset>

        </div>
        <div class="col-md-6 mb-4">
            <!-- <?= $form->field($model, 'Img2')->textInput(['maxlength' => true]) ?> -->
            <fieldset>
                <legend>Дополнительное изображение</legend>
                <?= $form->field($model, 'imageFile2')->fileInput([
                    'id' => 'Img2'
                ]); ?>

                <?php
                if (!empty($model->Img2)) {
                    $img2 = Yii::getAlias('@webroot') . '/img/' .  $model->Img2;
                    if (is_file($img2)) {
                        $url = Yii::getAlias('@web') . '/img/' .  $model->Img2;
                        echo 'Уже загружено ', Html::img('@web/img/' . $model->Img2, ['alt' => 'Product', 'class' => 'img adminBrend rounded mx-auto d-bloc']);
                        // echo $form->field($model, 'remove')->checkbox();
                    }
                }
                ?>

            </fieldset>

        </div>
    </div>
    <?= $form->field($model, 'Status')->dropDownList($items) ?>
    <?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Tegs')->textInput() ?>

    <?= $form->field($model, 'IdBrand')->
        //textInput()
        dropdownList(
            BrandProd::find()->select(['Brand', 'Id'])->indexBy('Id')->orderBy('Brand ASC')->column()
        )
    ?>
    <?= $form->field($model, 'Id_category')->dropdownList(
        $parents
        // Category::find()->select(['Name', 'Id'])->indexBy('Id')->orderBy('Name ASC')->column()
    ) ?>
    <div class="form-row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="ru-tab" data-toggle="tab" href="#ru" role="tab" aria-controls="ru" aria-selected="true">Русский</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ua-tab" data-toggle="tab" href="#ua" role="tab" aria-controls="ua" aria-selected="false">Українська</a>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="ru" role="tabpanel" aria-labelledby="ru-tab">
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
                    <?= $form->field($model, 'MetaDescription')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'MetaTitle')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'MetaKeyword')->textInput(['maxlength' => true]) ?>

                </div>
                <div class="tab-pane fade" id="ua" role="tabpanel" aria-labelledby="ua-tab">
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

                    <?= $form->field($model, 'MetaDescription_ua')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'MetaTitle_ua')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'MetaKeyword_ua')->textInput(['maxlength' => true]) ?>

                </div>

            </div>
        </div>
    </div>


    <div class="form-row">
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'Markup')->textInput([
                'maxlength' => true,
                'id' => 'Markup',
                'value' => !empty($model->Markup) ? $model->Markup : 50
            ]) ?>
            <?= $form->field($model, 'Conventional_units')->textInput([
                'maxlength' => true,
                'id' => 'Conventional_units'
            ]) ?>


        </div>
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'Id_current')->dropdownList(
                Current::find()->select(['Name', 'Id'])->indexBy('Id')->orderBy('Name ASC')->column()
            ) ?>
            <p class="mt-5 ml-5">Цена <span id='Price' class="text-danger  -light ml-2"></span> грн</p>

            <?//= $form->field($model, 'Price')->textInput([
            //     'readonly' => true,
            //     'id' => 'Price'
            // ]) ?>
        </div>
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'Units')->textInput(['maxlength' => true])

            ?>

            <p class="text-left text-warning">Текущий курс: 1 у.е = <input id='kurs' type="text" value="<?= $kurs['kurs'] ?>" readonly='true'>
                грн</p>

        </div>
    </div>
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'Availability')->textInput() ?>
        </div>
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'MinQunt')->textInput() ?>
        </div>
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'Id_discont')->dropdownList(
                Discont::find()->select(['Value_discont', 'Id'])->indexBy('Id')->orderBy('Value_discont ASC')->column()
            ) ?>

        </div>
    </div>



    <?// if(!$model->DateAdd):?>
    <?//= $form->field($model, 'DateAdd')->textInput(['readonly' => true]) ?>
    <?// endif?>
    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end();

    Pjax::end();
    ?>

</div>
<script>
    Markup.oninput = function() {
        // console.log(Markup.value)
        Price.innerHTML = (1 + Markup.value / 100) * kurs.value * Conventional_units.value;
    };
    // console.log(Price.value)
    Conventional_units.oninput = function() {
        // console.log(Markup.value)
        Price.innerHTML = (1 + Markup.value / 100) * kurs.value * Conventional_units.value;
    };
</script>
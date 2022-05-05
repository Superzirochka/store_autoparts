<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Store */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="store-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12 ">
            <ul class="nav nav-tabs bg-transparent" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="active nav-link" id="nav-contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="nav-contact" aria-selected="false">Данные о магазине </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link " id="home-tab" data-toggle="tab" href="#ru" role="tab" aria-controls="home" aria-selected="true"> О магазине (русский язык)</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#ua" role="tab" aria-controls="profile" aria-selected="false">Про магазин(українська мова)</a>
                </li>


            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <?= $form->field($model, 'Name_shop')->textInput(['maxlength' => true]) ?>


                    <?= $form->field($model, 'Phone')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Viber')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Facebook_link')->textInput(['maxlength' => true]) ?>


                    <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>


                    <?= $form->field($model, 'Date_add')->textInput() ?>

                    <?= $form->field($model, 'Owner')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Telegram_link')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Google_map')->textInput(['maxlength' => true]) ?>

                    <?//= $form->field($model, 'Logo')->textInput(['maxlength' => true]) ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <legend>Загрузить изображение</legend>
                            <p>размер изображения 500px на 150px</p>
                            <?= $form->field($model, 'logoBig')->fileInput([
                                'id' => 'imgFile'
                            ]); ?>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            if (!empty($model->Logo)) {
                                $img = Yii::getAlias('@webroot') . '/img/' . $model->Logo;
                                if (is_file($img)) {
                                    $url = Yii::getAlias('@web') . '/img/' . $model->Logo;
                                    echo 'Уже загружено<br>';
                                    echo Html::img('@web/img/' . $model->Logo, ['alt' => $model->Name_shop, 'class' => 'img adminBrend rounded mx-auto d-bloc']) . '<br>';
                                    echo 'имя файла: ' . $model->Logo;

                                    //  echo $form->field($model, 'remove')->checkbox();
                                }
                            }

                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <legend>Загрузить изображение</legend>
                            <?= $form->field($model, 'logoSmall')->fileInput([
                                'id' => 'logoSmall'
                            ]); ?>

                        </div>
                        <div class="col-sm-6">
                            <?php
                            if (!empty($model->logo_small)) {
                                $img = Yii::getAlias('@webroot') . '/img/' . $model->logo_small;
                                if (is_file($img)) {
                                    $url = Yii::getAlias('@web') . '/img/' . $model->logo_small;
                                    echo 'Уже загружено<br>';
                                    echo Html::img('@web/img/' . $model->logo_small, ['alt' => $model->Name_shop, 'class' => 'img adminBrend rounded mx-auto d-bloc']) . '<br>';
                                    echo 'имя файла: ' . $model->logo_small;

                                    //  echo $form->field($model, 'remove')->checkbox();
                                }
                            }

                            ?>
                        </div>
                    </div>
                    <?//= $form->field($model, 'logo_small')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'Info')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Id_lang')->textInput() ?>

                </div>
                <div class="tab-pane fade " id="ru" role="tabpanel" aria-labelledby="home-tab">
                    <p> О магазине (русский язык)</p>

                    <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Meta_title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Meta_description')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Meta_keyword')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Work_time')->textInput(['maxlength' => true])
                    ?>

                    <?= $form->field($model, 'Adress')->textInput(['maxlength' => true])
                    ?>



                </div>
                <div class="tab-pane fade" id="ua" role="tabpanel" aria-labelledby="profile-tab">
                    <p>Про магазин(українська мова)</p>
                    <?= $form->field($model, 'Description_ua')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Meta_title_ua')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Meta_description_ua')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Meta_keyword_ua')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Work_time_ua')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Adress_ua')->textInput(['maxlength' => true])
                    ?>




                </div>

            </div>
        </div>
    </div>

    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container my-shadow " id="content_box">

    <div class="row">

        <div class="col-sm-3">



            <?= app\components\CategoryWidget::widget(); ?>
            <!-- <?= app\components\BrandWidget::widget() ?> -->
        </div>
        <!-- content-->
        <div class="col-sm-9">
            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

            <p>Пожалуйста, заполните следующие поля:</p>
            <div class="row">

                <div class="form col-sm-12 mb-3">
                    <?php $form = ActiveForm::begin([
                        'options' => ['class' => 'my-shadow mt-1 mb-1', 'method' => 'POST', 'id' => 'signup-form']

                    ]); ?>
                    <div class="form-row">
                        <div class="col-md-5 mb-3">
                            <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>

                            <?= $form->field($model, 'password')->passwordInput() ?>
                            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                            <div class="form-group row">
                                <div class="form-check  ml-5">
                                    <?= $form->field($model, 'rememberMe')->checkbox([]) ?>
                                    <?= $form->field($model, 'news')->checkbox([])  ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 mb-3">
                            <?= $form->field($model, 'fname')->textInput(['autofocus' => true]) ?>
                            <?= $form->field($model, 'lname')->textInput(['autofocus' => true]) ?>
                            <?= $form->field($model, 'phone')->textInput(['autofocus' => true]) ?>
                            <?= $form->field($model, 'city')->textInput(['autofocus' => true, 'value' => 'Харьков']) ?>
                            <?= $form->field($model, 'adres')->textInput(['autofocus' => true, 'value' => 'Самовывоз, рынок Автоград, 4 ряд 31 магазин ']) ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12 d-flex justify-content-center">
                            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary w-50', 'name' => 'login-button']) ?>
                        </div>
                    </div>




                    <?php ActiveForm::end(); ?>
                </div>

            </div>
        </div>
    </div>
</div>
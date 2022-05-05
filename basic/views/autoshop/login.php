<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
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
            <p class="text-center">Пожалуйста, заполните следующие поля</p>
            <div class="d-flex justify-content-center">
                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'my-shadow mt-1 mb-3 col-sm-6 ', 'method' => 'POST', 'id' => 'login-form']
                ]); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox([]) ?>

                <div class="form-group">
                    <div class="d-sm-flex justify-content-around">
                        <?= Html::submitButton('Вход', ['class' => 'btn btn-primary  w-25', 'name' => 'login-button']) ?>
                        <a href="<?= yii\helpers\Url::to(['autoshop/singup']) ?>" class="btn btn-primary" title="Регистрация">Регистрация</a>
                    </div>
                </div>
                <div>
                    <p class="text-center"> Если вы забыли пароль, вы можете <?= Html::a(' сбросить пароль', ['autoshop/request-password-reset']) ?>.</p>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
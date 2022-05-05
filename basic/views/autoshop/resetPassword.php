<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container my-shadow " id="content_box">
    <div class="site-reset-password">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        <p class="text-center">Пожалуйста, выберите ваш новый пароль:</p>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
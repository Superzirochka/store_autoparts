<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container my-shadow " id="content_box">
    <div class="site-request-password-reset">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        <p class="text-center">Пожалуйста, заполните вашу электронную почту. Ссылка для сброса пароля будет отправлена ​​туда.</p>
        <div class="row  d-flex justify-content-center">
            <div class="col-sm-5">

                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                <div class="form-group d-flex justify-content-center">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
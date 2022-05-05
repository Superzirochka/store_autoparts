<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Аутентификация';
?>
<div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4" id="adminform">
        <div class="login-panel panel panel-default">
            <div class="panel-heading text-center pt-2">Вход в админку</div>
            <div class="panel-body">
                <div class="container">
                    <?php
                    $form = ActiveForm::begin();
                    ?>
                    <?= $form->field($model, 'email')->input('email'); ?>
                    <?= $form->field($model, 'password')->input('password'); ?>
                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php
                    ActiveForm::end();
                    ?>
                </div>

            </div>
        </div>
    </div><!-- /.col-->
</div>
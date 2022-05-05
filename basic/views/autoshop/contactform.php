<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Обратная связь';
$this->params['breadcrumbs'][] = $this->title;
/*
 * Если данные формы не прошли валидацию, получаем из сессии сохраненные
 * данные, чтобы заполнить ими поля формы, не заставляя пользователя
 * заполнять форму повторно
 */
$name = '';
$email = '';
$body = '';
$subject = '';
if (Yii::$app->session->hasFlash('feedback-data')) {
    $data = Yii::$app->session->getFlash('feedback-data');
    $name = Html::encode($data['name']);
    $email = Html::encode($data['email']);
    $body = Html::encode($data['body']);
    $subject = Html::encode($data['subject']);
}

$js =
    <<<JS
$('#contact-form').on('beforeSubmit', function() {
    var form = $(this);
  //  var data = form.serialize();
    var data = {'value': 'some value'};
// var param = $('meta[name=csrf-param]').attr('content');
// var token = $('meta[name=csrf-token]').attr('content');
var param = yii.getCsrfParam();
var token = yii.getCsrfToken();
data[param] = token;
    // отправляем данные на сервер
    $.ajax({
        url: '/some/handler',//form.attr('action'),
        type: 'post',//form.attr('method'),
        data: data
    })
    .done(function(data) {
        if (data.success) {
            // данные прошли валидацию, сообщение было отправлено
            $('#response').html(data.message);
            form.children('.has-success').removeClass('has-success');
            form[0].reset();
        }
    })
    .fail(function () {
        alert('Произошла ошибка при отправке данных!');
    })
    return false; // отменяем отправку данных формы
});
JS;

$this->registerJs($js, $this::POS_READY);
?>

<div class="container my-shadow " id="content_box">
    <div class="row">
        <div class="col-sm-3">
            <?= app\components\CategoryWidget::widget() ?>
            <!-- <?= app\components\BrandWidget::widget() ?> -->
        </div>
        <div class="col-sm-9">
            <div class="contact-message">
                <?php
                $success = false;
                if (Yii::$app->session->hasFlash('feedback-success')) {
                    $success = Yii::$app->session->getFlash('feedback-success');
                }
                ?>
                <div id="response">
                    <?php if (!$success) : ?>
                        <?php if (Yii::$app->session->hasFlash('feedback-errors')) : ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <p>При заполнении формы допущены ошибки</p>
                                <?php $allErrors = Yii::$app->session->getFlash('feedback-errors'); ?>
                                <ul>
                                    <?php foreach ($allErrors as $errors) : ?>
                                        <?php foreach ($errors as $error) : ?>
                                            <li><?= $error; ?></li>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <p>Ваше сообщение успешно отправлено</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php $form = ActiveForm::begin(['id' => 'contact-form', 'class' => 'form-horizontal']); ?>

                <?= $form->field($model, 'name')->textInput(['value' => $name]); ?>
                <?= $form->field($model, 'email')->input('email', ['value' => $email]); ?>
                <?= $form->field($model, 'subject')->input('subject', ['value' => $subject]); ?>
                <?= $form->field($model, 'body')->textarea(['rows' => 5, 'value' => $body]); ?>
                <div class="form-group d-flex justify-content-center">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Подтверждение';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="container my-shadow " id="content_box">
    <div class="row">
        <div class="col-md-3">
            <?= app\components\CategoryWidget::widget() ?>
            <!-- <?= app\components\BrandWidget::widget() ?> -->
        </div>
        <div class="col-md-9 mb-3">
            <h2 class="text-center"><?= $this->title ?></h2>
            <?= app\components\AutobrendWidget::widget() ?>
            <p><?= $name . ' ' . $lastname ?> ,спасибо за покупку. Ваш заказ успешно оформлен, подтверждение отправленно на электронную почту <?= $email ?> </p>
            <p>В ближайшее время с Вами свяжеться наш менеджер.</p>
            <a href="<?= Url::home() ?>" class="btn  btn-lg btn-block " id='myBackgra'>Вернуться на главную</a>
        </div>

    </div>

</div>
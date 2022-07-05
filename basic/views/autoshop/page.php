<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\Store;

$this->title = $page['Name'];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="container my-shadow " id="content_box">
    <div class="row">
        <div class="col-sm-2">
            <h2> <?= $page['Name']; ?></h2>

        </div>
        <div class="col-sm-10">

            <? if (!$page['Content']) : ?>
                <h3 class='text-center mb-5'>Інформація відсутня...</h3>
            <? endif ?>
            <?= $page['Content']; ?>
            <div class="form-group d-flex justify-content-around mb-5">
                <? if ($lang['Id'] == 1) : ?>
                    <a href="<?= yii\helpers\Url::to(['autoshop/contact']) ?>" class="btn btn-primary w-25" title="ви будете перенаправлені на сторінку контакти">Зв'язатися з нами</a>
                    <a href="<?= yii\helpers\Url::to(['autoshop/index']) ?>" class="btn btn-primary w-25 ">На головну</a>
                <? else : ?>
                    <a href="<?= yii\helpers\Url::to(['autoshop/contact']) ?>" class="btn btn-primary w-25" title="ви будете перенаправлені на сторінку контакти">Связаться с нами</a>
                    <a href="<?= yii\helpers\Url::to(['autoshop/index']) ?>" class="btn btn-primary w-25 ">На главную</a>
                <? endif ?>
            </div>
        </div>
    </div>

</div>
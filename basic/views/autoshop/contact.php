<?php
/* @var $this yii\web\View */

use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;
$tel = [];
$work = [];

array_push($tel, explode(',', $store->Phone, 18));
array_push($work, explode(',', $store->Work_time, 18));


?>
<div class="container my-shadow " id="content_box">


    <div class="row pb-5">
        <div class="col-sm-12 ml-1 mr-1">
            <h3 class="text-center"> Контаткы </h3>
        </div>

        <div class="col-sm-7 ">
            <div class="map">

                <h4 class="text-center">Карта проезда</h4>
                <iframe src="<?= $store->Google_map ?>" width="600" height="450" frameborder="0" style="border:0" allowfullscreen class="col-sm-12"></iframe>
            </div>
        </div>
        <div class="col-sm-5  ">
            <h4 class="text-center pl-5">Контакты</h4>
            <div class="adres pl-5">

                <h5>Адрес:</h5>
                <p class="font-italic"><?= $store->Adress ?></p>
                <h5>Телефоны:</h5>
                <? foreach ($tel[0] as $t) : ?>
                <p class="font-italic"> <?= $t ?> </p>
                <? endforeach ?>

                <a href="viber://chat?number=%2B<?= $store->Viber ?>">
                    <div class="sprites viber  pr-5">
                        <strong class=" font-italic ml-5">
                            <?= preg_replace("/\s+/", "", $store->Viber) ?>
                    </div>
                    </strong>
                </a>
                <h5>Режим работы</h5>
                <? foreach ($work[0] as $w) : ?>
                <p class="font-italic"> <?= $w ?> </p>
                <? endforeach ?>


            </div>
            <div class="row d-flex justify-content-center">

                <a href="<?= yii\helpers\Url::to(['autoshop/contactform']) ?>" class="btn btn-primary w-75 ">
                    Написать нам
                </a>

            </div>

        </div>
    </div>

</div>
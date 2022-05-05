<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Banner;
use app\models\BannerImg;


$sliders = BannerImg::find()->select('Id, IdBanner, Title, Link, Img')->where(['IdBanner' => 1])->all();
$j = 1;
$i = 1;
$title = [];
//$i = $sliders->count();
foreach ($sliders as $slider) {
    array_push($title, explode('//', $slider->Title, 5));
}


?>

<div class="col-sm-12 ">

    <div class="carousel my-shadow mt-sm slide" data-ride="carousel" id="carouselExampleIndicators">
        <ol class="carousel-indicators">
            <? for ($i = 0; $i < count($sliders); $i++) : ?>
            <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>" class="active bg-dark"></li>
            <? endfor ?>

        </ol>
        <div class="carousel-inner">

            <div class="carousel-item active">
                <a href="<?= yii\helpers\Url::to([$sliders[0]->Link]) ?>"><?= Html::img('@web/img/' . $sliders[0]->Img, ['alt' => 'slider' . $sliders[0]->Id, 'class' => 'd-block w-100']) ?></a>

            </div>

            <? for ($i = 1; $i < count($sliders); $i++) : ?>
            <div class="carousel-item">
                <a href="<?= yii\helpers\Url::to([$sliders[$i]->Link]) ?>"><?= Html::img('@web/img/' . $sliders[$i]->Img, ['alt' => 'slider' . $sliders[$i]->Id, 'class' => 'd-block w-100']) ?></a>

            </div>
            <? endfor ?>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                <span class="sr-only bg-dark">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
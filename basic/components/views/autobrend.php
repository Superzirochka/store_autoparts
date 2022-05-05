<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\ManufacturerAuto;
use app\models\BannerImg;

$autobrend = ManufacturerAuto::find()->select('Id, Marka, Img, link')->all();
?>



<div class="owl-carousel owl-theme col-sm-12">
    <? foreach ($autobrend as $marka) : ?>
    <div>
        <a href=" <?= yii\helpers\Url::to(['autocatalog/index', 'id' => $marka->Id]) ?><?= $marka->Link ?>"><?= Html::img('@web/img/' . $marka->Img, ['alt' => $marka->Marka, 'class' => 'brendImg img']) ?></a>

    </div>
    <? endforeach ?>
</div>
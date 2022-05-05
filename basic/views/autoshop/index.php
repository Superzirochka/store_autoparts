<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

//$this->title = 'Home';
//$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container my-shadow " id="content_box">
    <div class="row">
        <? //= app\components\AutoWidget::widget(); 
        ?>
        <?= $this->render('_auto', [
            'model' => $model,
        ]) ?>
    </div>

    <div class="row ">
        <!--карусель-->
        <?= app\components\BannerWidget::widget() ?>
        <!-- <img src="http://www.fps-catalog.com.ua/img.php?m=bd&amp;id=0011011" id="imgbd0011011"> -->

    </div>


    <div class="row">
        <!--рекомендованный товар-->
        <a href="<?= yii\helpers\Url::to(['api/products/view', 'id' => 1,]) ?>" class="badge myBackgra">
            api
        </a>

        <?= app\components\Recomendprod::widget() ?>


    </div>
    <div class="row fabric">
        <!--карусель марок-->
        <?= app\components\AutobrendWidget::widget(); ?>

    </div>

</div>
<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>


<div class="col-lg-12 p-5">
    <h3 class="page-header text-center">Популярные товары</h3>
</div>

<div class="owl-carouselRec card-group mr-5 mb-5 pr-5 owl-theme col-sm-12">

    <? foreach ($recItem as $rItem) : ?>
    <?     
    
     if (!empty($rItem->Img)) {
         $img = Yii::getAlias('@webroot') . '/img/' . $rItem->Img;
         if (is_file($img)) {
             $url = Yii::getAlias('@web') . '/img/' . $rItem->Img;
             

             //  echo $form->field($model, 'remove')->checkbox();
         }else{
            $url= Yii::getAlias('@web') . '/img/products/defult_prodact.jpg';
         }
     }else{
         $url= Yii::getAlias('@web') . '/img/products/defult_prodact.jpg';
     }
    
    ?>
    <div class="card text-center heightCard">
        <a href=" <?= yii\helpers\Url::to(['autoshop/view', 'id' => $rItem->Id]) ?>">
            <?= Html::img($url, ['class' => 'card-img-top pic']) ?>
        </a>
        <div class="card-body overflow-hidden">
            <h5 class="card-title"><?= $rItem->Name ?></h5>
            <p class="card-text"><?= $rItem->MetaTitle ?></p>

        </div>
        <div class="card-footer"><?= $rItem->Price . ' ' . $rItem->current->Name ?></div>
    </div>

    <? endforeach ?>
</div>
<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Акции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container my-shadow " id="content_box">
    <div class="row">
        <div class="col-sm-3">
            <?= app\components\CategoryWidget::widget(); ?>
            <!-- <?= app\components\BrandWidget::widget() ?> -->
        </div>

        <div class="col-sm-9 mb-5">
            <?foreach($actions as $action):?>
            <div class="card mb-2">
                <?// echo $action->Img;
                if (!empty($action->Img)) {
                 $img = Yii::getAlias('@webroot') . '/img/' . $action->Img;
                 if (is_file($img)) {
                     $url = Yii::getAlias('@web') . '/img/' . $action->Img;
                     
                     $sth= '';
                 }else{
                   
                     $sth= 450;
                 }
                     }
                     //echo $model->Img;
                ?>
                <?//if(!empty($action->Img)):?>
                <?= Html::img($url, [
                    'alt' => $action->Name,  'class' => 'card-img mb-5 ',
                    'height' => $sth
                ])

                ?>

                <div class="card-img-overlay">
                    <div class="row d-flex justify-content-between">
                        <h5 class="card-title mycolor"><?= $action->Name ?></h5>

                        <p class="card-text mycolor">Дата публикации: <?= $action->DateAdd ?> </p>
                    </div>

                    <p class="card-text mycolor">
                        <?= $action->Content ?>
                    </p>

                </div>
            </div>


            <?endforeach?>
        </div>
    </div>
</div>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\BannerImg;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Изображения слайдера : {name}', [
    'name' => $banner->Name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Слайдеры'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', $this->title);

?>
<div class="banner-images">
    <div class="d-flex justify-content-between">
        <h1><?= Html::encode($this->title) ?></h1>
        <a class="btn mt-3" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>
    <?= Html::a(Yii::t('app', 'Добавить изображение'), ['addimg', 'id' => $banner->Id], ['class' => 'btn btn-success']) ?>
    <hr>

    <?foreach($images as $img):?>
    <div class="row mt-3">
        <div class="col-sm-4">
            <?= Html::img('@web/img/' . $img->Img, ['alt' => $img->Title, 'class' => 'img-thumbnail', 'width' => 280, 'height' => 180]) ?>
        </div>
        <div class="col-sm-6">
            <p>Описание: <?= $img->Title ?></p>
            <?if  (!$img->Link){
$text = '  Ссылка отсутствует';
            }else{
                $text =$img->Link;
            }?>
            <p>Ссылка: <?= $text ?></p>

        </div>
        <div class="col-sm-2">
            <?= Html::a(Yii::t('app', 'Редактировать изображение'), ['updateimg', 'id' => $img->Id], ['class' => 'btn btn-info']) ?>
            <?= Html::a(Yii::t('app', 'Удалить изображение'), ['deleteimg', 'id' => $img->Id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Вы уверены что хотите удалить это изображение?'),
                    'method' => 'post',
                ],
            ]) ?>

        </div>
    </div>
    <?endforeach?>


</div>
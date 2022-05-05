<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BrandProd */

$this->title = $model->Brand;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Бренд'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="brand-prod-view">

    <div class="d-flex justify-content-between">
        <h2 class="mt-3"><?= Html::encode($this->title) ?></h2>
        <a class="btn mt-3" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'Id',
            [
                'label' => '№',
                'attribute' => 'Id',
            ],
            'Brand',
            //'Img',
            [
                'attribute' => 'Img',
                'value' =>  '@web/img/' . $model->Img,
                'format' => ['image', ['class' => 'img adminBrend rounded mx-auto d-block']],

            ],


        ],
    ]) ?>


    <div class="d-flex justify-content-around">
        <?= Html::a(Yii::t('app', 'Обновить'), ['update', 'id' => $model->Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->Id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены что хотите удалить ' . $this->title . '?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

</div>
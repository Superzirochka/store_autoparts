<?php

use app\modules\admin\models\NodeAuto;
use app\modules\admin\models\ManufacturerAuto;
use app\modules\admin\models\Modification;
use app\modules\admin\models\ModelAuto;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ManufacturerAuto */

$this->title = $model->OEM;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Марки автомобилей'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="manufacturer-auto-view">
    <div class="d-flex justify-content-between">

        <h2 class="mt-5 pl-0"><?= Html::encode($this->title)  ?></h2>
        <a class="btn mt-5" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>
    <div class="row d-flex justify-content-around mb-3">



        <?= Html::a(Yii::t('app', 'Редактировать'), ['updateoem', 'id' => $model->Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Товары по OEM'), ['products', 'OEM' => $model->OEM], [
            'class' => 'btn btn-primary',

        ]) ?>
    </div>
    <?
$node=NodeAuto::find()->where(['Id' => $model->IdNode])->one();
$modif = Modification::findOne($model->Id_auto);
$models = ModelAuto::findOne($modif->IdModelAuto);
$marka=ManufacturerAuto::find()->where(['Id' => $models->IdManufacturer])->one();
?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Id',
            'OEM',
            [
                'attribute' => 'IdNode',
                'value' => $node->Node,
            ],
            [
                'attribute' => 'Id_auto',
                'value' => $models->FullName,
            ],
            'Description_ua:html', 'Description:html',
            // 'IdNode' => Yii::t('app', 'Узел авто'),
            // 'Id_auto' => Yii::t('app', 'Модель авто'),
            // 'Img' => Yii::t('app', 'Изображение'),           
            // 'Description' => Yii::t('app', 'Описание'),
            // 'Description_ua' => Yii::t('app', 'Опис'),

            [
                'attribute' => 'Img',
                'value' =>  '@web/img/' . $model->Img,
                'format' => ['image', ['class' => 'img adminBrend rounded mx-auto d-block']],

            ],
            //'Link',
        ],
    ]) ?>

</div>
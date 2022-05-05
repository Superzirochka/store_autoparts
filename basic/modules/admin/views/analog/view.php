<?php

use app\modules\admin\models\ManufacturerAuto;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Analog */

$this->title = $model->OEM;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Аналоги'), 'url' => ['index']];
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
            [
                'attribute' =>  'Marka',
                'value' =>  function ($data) {
                    $engine = ManufacturerAuto::find()->where(['Id' => $data->Marka])->one();
                    return $engine->Marka;
                },
                // 'filter' => ManufacturerAuto::find()->select('Id, Marka'),
            ],
            'OEM',
            'Analog',
            'Brand',

        ],
    ]) ?>


    <div class="d-flex justify-content-around">
        <?= Html::a(Yii::t('app', 'Обновить'), ['update', 'oem' => $model->OEM, 'analog' => $model->Analog], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'oem' => $model->OEM, 'analog' => $model->Analog], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены что хотите удалить ' . $this->title . '?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

</div>
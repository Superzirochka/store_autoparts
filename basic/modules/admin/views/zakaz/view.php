<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Zakaz */

$this->title = $model->Id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Запросы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Запрос № ' . $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="zakaz-view">
    <div class="d-flex justify-content-between">

        <h2 class="mt-3">Запрос № <?= Html::encode($this->title) ?> от <?= $model->DateAdd ?></h2>
        <a class="btn mt-3" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>
    <p>
        <?= Html::a(Yii::t('app', 'Обновить'), ['update', 'id' => $model->Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->Id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить запрос № ' . $model->Id . ' от ' . $model->DateAdd . ' ?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Id',
            'MarkaAuto',
            'ModelAuto',
            'YearCon',
            'ValueEngine',
            'VIN',
            'Description',
            'FIO',
            'Email:email',
            'Phone',
            'DateAdd',
            [
                'attribute' => 'Status',
                'value' =>  function ($data) {
                    switch ($data->Status) {
                        case 'new':
                            return 'Новый !!!';
                        case 'processed':
                            return 'В обработке';
                        case 'completed':
                            return 'Завершен';
                        case 'delete':
                            return 'Удален';
                        default:
                            return 'Ошибка';
                    }
                },
            ],
        ],
    ]) ?>

</div>
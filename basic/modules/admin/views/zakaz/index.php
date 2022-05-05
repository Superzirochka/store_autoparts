<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Запросы');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakaz-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?//= //Html::a(Yii::t('app', 'Добавить запрос'), ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'DateAdd',
            // 'Id',
            'MarkaAuto',
            'ModelAuto',
            // 'YearCon',
            //'ValueEngine',
            //'VIN',
            'Description',
            //'FIO',
            //'Email:email',
            //'Phone',

            [
                'attribute' => 'Status',
                'value' =>  function ($data) {
                    switch ($data->Status) {
                        case 'new':
                            return '<span class="text-danger">Новый !!!</span>';
                        case 'processed':
                            return '<span class="text-warning">В обработке</span>';
                        case 'completed':
                            return '<span class="text-success">Завершен</span>';
                        case 'delete':
                            return '<span class="text-success">Удален</span>';
                        default:
                            return 'Ошибка';
                    }
                },
                'format' => 'html'
            ],

            ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
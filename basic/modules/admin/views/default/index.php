<?php
/*
 * Файл view-шаблона modules/admin/views/default/index.php
 */

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $queueOrders yii\data\ActiveDataProvider */
/* @var $processOrders yii\data\ActiveDataProvider */

$this->title = 'Текущее состояние';
?>

<h1><?= Html::encode($this->title) ?></h1>

<h2 class="mt-3">Новые заказы</h2>

<?=
    GridView::widget([
        'dataProvider' => $queueOrders,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'Id',
            'OrderNumber',
            ///'IdUser',
            'Name',
            'LastName',
            //  'Email:email',
            //'Phone',
            //'City',
            //'IdDostavka',
            //'Comment',
            'Amount',
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    switch ($data->Status) {
                        case 'new':
                            return '<span class="text-danger">Новый</span>';
                        case 'processed':
                            return '<span class="text-warning">Обработан</span>';
                        case 'paid':
                            return '<span class="text-warning">Оплачен</span>';
                        case 'delivered':
                            return '<span class="text-warning">Доставлен</span>';
                        case 'completed':
                            return '<span class="text-success">Завершен</span>';
                        default:
                            return 'Ошибка';
                    }
                },
                'format' => 'html'
            ],
            'DateAdd',
            'DateUpdate'
        ],
    ]);
?>

<h2 class="mt-3">Заказы в работе</h2>

<?=
    GridView::widget([
        'dataProvider' => $processOrders,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //  'Id',
            'OrderNumber',
            ///'IdUser',
            'Name',
            'LastName',
            //  'Email:email',
            //'Phone',
            //'City',
            //'IdDostavka',
            //'Comment',
            'Amount',
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    switch ($data->Status) {
                        case 'new':
                            return '<span class="text-danger">Новый</span>';
                        case 'processed':
                            return '<span class="text-warning">Обработан</span>';
                        case 'paid':
                            return '<span class="text-warning">Оплачен</span>';
                        case 'delivered':
                            return '<span class="text-warning">Доставлен</span>';
                        case 'completed':
                            return '<span class="text-success">Завершен</span>';
                        default:
                            return 'Ошибка';
                    }
                },
                'format' => 'html'
            ],
            'DateAdd',
            'DateUpdate',

        ],
    ]);
?>
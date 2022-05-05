<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Заказы');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-shop-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'Id',
            'OrderNumber',
            // 'IdUser',
            'Name',
            'LastName',
            //  'Email:email', 
            //'Phone',
            //'City',
            //'IdDostavka',
            //'Comment',
            'Amount',
            [
                'attribute' => 'Status',
                'value' =>  function ($data) {
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
            //'DateAdd',
            //'IdOplata',
            //'Mailing',
            //'Adress',

            ['class' => 'yii\grid\ActionColumn'],
            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'template' => '{view, delete, update}',
            //     'buttons' => [
            //         'delete' => function ($url, $model, $key) {

            //             $url = Url::current(['delete', 'id' => $model->Id]);

            //             //Для стилизации используем библиотеку иконок

            //             return \yii\helpers\Html::a(
            //                 '<span class="mr-5">  D  </span>',
            //                 $url,
            //                 ['title' => Yii::t('yii', 'delete')]
            //             );
            //         },
            //     ],
            //],
        ],
    ]); ?>


</div>
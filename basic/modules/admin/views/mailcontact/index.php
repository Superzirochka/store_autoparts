<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Сообщения');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-contact-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a(Yii::t('app', 'Create Mail Contact'), ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'Status',
                'value' =>  function ($data) {
                    switch ($data->Status) {
                        case 'new':
                            return '<span class="text-danger">Новый</span>';
                        case 'processed':
                            return '<span class="text-warning">В работе</span>';
                        case 'considered':
                            return '<span class="text-warning">Рассмотрен</span>';
                        case 'completed':
                            return '<span class="text-success">Завершен</span>';
                        case 'delete':
                            return '<span class="text-success">Удалено</span>';
                        default:
                            return 'Ошибка';
                    }
                },
                'format' => 'html'
            ],
            //'Id',
            'FIO',
            'TitleMessage',
            // 'Message',
            'Email:email',

            //'DateAdd',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
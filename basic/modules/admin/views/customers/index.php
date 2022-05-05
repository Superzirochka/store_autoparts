<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Покупатели');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customers-index">


    <h1>Группы покупателей</h1>

    <?= Html::a(Yii::t('app', 'Добавить группу'), ['addgruop'], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider' => $groupCustom,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //   'Id',
            'Name',

            [
                'class' => 'yii\grid\ActionColumn',
                    'template' => '{info}{delgruop}',
                    'buttons' => [
                        'info' => function ($url, $model, $key) {


                            $url = Url::current(['info', 'id' => $model->Id]);

                            //Для стилизации используем библиотеку иконок

                            return \yii\helpers\Html::a(
                                '<span class="mr-5">  &#10148;  </span>',
                                $url,
                                ['title' => Yii::t('yii', 'редактировать')]
                            );
                        },
                        'delgruop' => function ($url, $model, $key) {


                            $url = Url::current(['delgruop', 'id' => $model->Id]);
                            return \yii\helpers\Html::a(
                                '<span class="">   &#10006;</span>',
                                $url,
                                [
                                    'title' => Yii::t('yii', 'удалить'),
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Вы уверены что хотите удалить ?'),
                                        'method' => 'post',
                                    ],


                                ]
                            );
                        },
                ],
                // 'template' => '{info}{delGruop}',
            ],
        ],
    ]); ?>


    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'Id',
            'Login',
            'FName',
            'LName',
            'Email:email',
            //'Phone',
            //'Password',
            //'News',
            //'City',
            //'Adres',
            //'IdGruop',
            //'hash',
            //'password_reset_token',
            // 'Status',
            [
                'attribute' => 'Status',
                'value' =>  function ($data) {
                    switch ($data->Status) {
                        case '0':
                            return '<span class="text-danger">Удален</span>';
                        case '10':
                            return '<span class="text-warning">Активный</span>';

                        default:
                            return 'Ошибка';
                    }
                },
                'format' => 'html'
            ],
            //'DateRegistration',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
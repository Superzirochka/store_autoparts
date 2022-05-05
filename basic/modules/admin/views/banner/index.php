<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\BannerImg;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Слайдеры');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить слайдер'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'Id',            
            [
                'attribute' => 'Status',
                'value' =>  function ($data) {
                    switch ($data->Status) {
                        case '1':
                            return 'Активный';
                        case '0':
                            return 'Неактивный';

                        default:
                            return 'Ошибка';
                    }
                },
            ],
            'Name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{info}{view}{update}{delete}',
                'buttons' => [
                    'info' => function ($url, $model, $key) {

                        $url = Url::current(['images', 'id' => $model->Id]);

                        //Для стилизации используем библиотеку иконок

                        return \yii\helpers\Html::a(
                            '<span class="glyphicon glyphicon-list mr-3"></span>',
                            $url,
                            ['title' => Yii::t('yii', 'Изображения слайдера')]
                        );
                    },

                ],
            ],
        ]
    ]); ?>


</div>
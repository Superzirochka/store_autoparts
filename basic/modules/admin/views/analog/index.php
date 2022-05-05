<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Аналоги');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacturer-auto-index">

    <h1><?= Html::encode($this->title) . ' ' . $oem ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить Аналог'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'OEM',
            'Analog',
            'Brand',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}{update}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        // $item = ModelAuto::find()->select('Id, IdManufacturer, ModelName, FullName, constructioninterval')->where(['IdManufacturer' => $model->Id])->one();

                        $url = Url::current(['view', 'oem' => $model->OEM, 'analog' => $model->Analog]);

                        //Для стилизации используем библиотеку иконок

                        return \yii\helpers\Html::a(
                            '<span class="glyphicon glyphicon-eye-open"> </span>',
                            $url,
                            ['title' => Yii::t('yii', 'Просмотр')]
                        );
                    },
                    'update' => function ($url, $model, $key) {
                        // $item = ModelAuto::find()->select('Id, IdManufacturer, ModelName, FullName, constructioninterval')->where(['IdManufacturer' => $model->Id])->one();

                        $url = Url::current(['update', 'oem' => $model->OEM, 'analog' => $model->Analog]);

                        //Для стилизации используем библиотеку иконок

                        return \yii\helpers\Html::a(
                            '<span class="glyphicon glyphicon-pencil"> </span>',
                            $url,
                            ['title' => Yii::t('yii', 'Редактировать')]
                        );
                    },
                    'delete' => function ($url, $model, $key) {
                        // $item = ModelAuto::find()->select('Id, IdManufacturer, ModelName, FullName, constructioninterval')->where(['IdManufacturer' => $model->Id])->one();

                        $url = Url::current(['delete', 'oem' => $model->OEM, 'analog' => $model->Analog]);

                        //Для стилизации используем библиотеку иконок

                        return \yii\helpers\Html::a(
                            '<span class="glyphicon glyphicon-trash"> </span>',
                            $url,
                            ['title' => Yii::t('yii', 'Удалить')]
                        );
                    },

                ],

            ],
        ],
    ]); ?>
</div>
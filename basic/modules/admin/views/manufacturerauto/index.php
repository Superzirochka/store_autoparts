<?php

use app\modules\admin\models\ModelAuto;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ManufacturerautoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Марки автомобилей');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacturer-auto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить марку'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Id',
            'Marka',
            [
                'attribute' => 'Img',
                'contentOptions' => ['class' => 'table_class'],
                'content' => function ($data) {
                    return
                        Html::img('@web/img/' . $data->Img, ['alt' => $data->Marka, 'class' => 'img adminBrend rounded mx-auto d-block']);
                },
                'filter' => false,
            ],
            //  'Link',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{modelsauto} {view}{delete}{update}',
                'buttons' => [
                    'modelsauto' => function ($url, $model, $key) {
                        // $item = ModelAuto::find()->select('Id, IdManufacturer, ModelName, FullName, constructioninterval')->where(['IdManufacturer' => $model->Id])->one();

                        $url = Url::current(['modelsauto', 'id' => $model->Id]);

                        //Для стилизации используем библиотеку иконок

                        return \yii\helpers\Html::a(
                            '<span class="glyphicon glyphicon-list"> </span>',
                            $url,
                            ['title' => Yii::t('yii', 'Модели марки')]
                        );
                    },

                ],
            ],
        ],
    ]); ?>


</div>
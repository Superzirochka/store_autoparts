<?php


use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\Products;
use app\modules\admin\models\ProductsSearch;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\modules\admin\models\Supplier;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = Yii::t('app', 'Поиск по коду ' . $query);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">
    <div class="d-flex justify-content-between">

        <h1 class="mt-3"><?= Html::encode($this->title) ?></h1>

        <p class="mt-5">
            <?= Html::a(Yii::t('app', 'Добавить товар'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <p class="mt-5">
            <a class="btn" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
        </p>
    </div>
    <hr>

    <!-- <?php Pjax::begin([
                'timeout' => 100000,
                'id' => 'pjax-container-table',
            ]); ?> -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'Status',
                'value' =>  function ($data) {
                    switch ($data->Status) {
                        case '10':
                            return 'Активный';
                        case '0':
                            return 'Удален';

                        default:
                            return 'Ошибка';
                    }
                },
                'filter' => ['10' => 'Активный', '0' => 'Удален'],
            ],
            //'Id',
            [
                'attribute' => 'Name',

            ],

            [
                'attribute' => 'MetaTitle',
                'filter' => true,
                // 'filterOptions' => ['style' => 'width: 100px']
            ],

            [
                'attribute' => 'Price',
                'filter' => true,
                // 'filterOptions' => ['style' => 'width: 100px']

            ],
            [
                'attribute' => 'DateAdd',
                'format' => ['date', 'php:Y-m-d'],
                'filter' => false,
            ],
            //'Id_discont',
            [
                'attribute' => 'Id_discont',
                'value' =>  function ($data) {
                    switch ($data->Id_discont) {
                        case '1':
                            return '0 %';
                        case '2':
                            return '10 %';
                        case '3':
                            return '15 %';
                        case '4':
                            return '20 %';
                        default:
                            return 'Ошибка';
                    }
                },
            ],
            //  'Availability',
            //  'Id_current',
            //  'MinQunt',
            //  'Units',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <!-- <?php Pjax::end(); ?> -->
    <p>Заказной товар</p>
    <?= GridView::widget([
        'dataProvider' => $dataProviderZakaz,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'Id',
            //'Supplier',
            [
                'attribute' => 'Supplier',
                'value' =>  function ($data) {
                    //  $item = $data->getIdProduct();
                    // $query = Products::find()->select(' Id, Name, Description, Img, Img2, Tegs, MetaDescription, MetaTitle, MetaKeyword, IdBrand, Id_lang, Id_category, Price, Id_discont, Availability, Id_current, MinQunt, DateAdd')->where(['IdBrand' => $idBrand, 'Status' =>10]);
                    $item = Supplier::find()->select('Id, Supplier')->where(['Id' => $data->Supplier])->one();


                    return $item->Supplier;
                    //echo $data->IdProduct;
                },
                // 'filter' =>
                // Supplier::find()->select('Supplier')->indexBy('Id')->orderBy('Supplier ASC')
                //     ->column()
                //  ->all()
                // ,
            ],
            'Brand',
            'ProductName',
            'Description',
            'EntryPrice',
            'Markup',
            'Price',
            'TermsDelive',
            //'Img',
            //'Count',

            [
                //'class' => 'yii\grid\ActionColumn'
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {


                        $url = Url::toRoute(['zakaz-products/view', 'id' => $model->Id]);

                        //Для стилизации используем библиотеку иконок

                        return \yii\helpers\Html::a(
                            '<span class="glyphicon glyphicon-eye-open"> </span>',
                            $url,
                            ['title' => Yii::t('yii', 'просмотр')]
                        );
                    },

                    'update' => function ($url, $model, $key) {


                        $url = Url::toRoute(['zakaz-products/update', 'id' => $model->Id]);

                        //Для стилизации используем библиотеку иконок

                        return \yii\helpers\Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            $url,
                            ['title' => Yii::t('yii', 'редактировать')]
                        );
                    },

                    'delete' => function ($url, $model, $key) {


                        $url = Url::toRoute(['zakaz-products/delete', 'id' => $model->Id]);

                        //Для стилизации используем библиотеку иконок

                        return \yii\helpers\Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            $url,
                            ['title' => Yii::t('yii', 'удалить')]
                        );
                    },

                ],
            ],
        ],
    ]); ?>


</div>
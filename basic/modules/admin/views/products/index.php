<?php


use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\Products;
use app\modules\admin\models\ProductsSearch;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$dataProvider->pagination->pageParam = 'prods-page';
$dataProvider->sort->sortParam = 'prods-sort';

$dataReviews->pagination->pageParam = 'reviews-page';
$dataReviews->sort->sortParam = 'reviews-sort';

$this->title = Yii::t('app', 'Товары');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">
    <div class="d-flex justify-content-between">

        <h1 class="mt-3"><?= Html::encode($this->title) ?></h1>

        <p class="mt-5">
            <?= Html::a(Yii::t('app', 'Добавить товар'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <p class="mt-5">
            <?= Html::a(Yii::t('app', 'Загрузить из файла'), ['exseladd'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="mt-3">
            <?= $this->render('_kursform', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

    <hr>
    <!-- <?php Pjax::begin([
                'timeout' => 100000,
                'id' => 'pjax-container-table',
            ]); ?> -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
            'Conventional_units',
            'Markup',
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
            // [
            //     'attribute' => 'Id_discont',
            //     'value' =>  function ($data) {
            //         switch ($data->Id_discont) {
            //             case 1:
            //                 return '0 %';
            //             case 2:
            //                 return '10 %';
            //             case 3:
            //                 return '15 %';
            //             case 4:
            //                 return '20 %';
            //             default:
            //                 return 'Ошибка';
            //         }
            //     },
            // ],
            //  'Availability',
            //  'Id_current',
            //  'MinQunt',
            //  'Units',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <!-- <?php Pjax::end(); ?> -->

    <h3>Отзывы от товарах</h3>
    <hr>
    <?= GridView::widget([
        'dataProvider' => $dataReviews,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'Id',
            'Name',
            'Title',
            //'Review',
            'Raiting',
            [
                'attribute' => 'IdProduct',
                'value' =>  function ($data) {
                    //  $item = $data->getIdProduct();
                    // $query = Products::find()->select(' Id, Name, Description, Img, Img2, Tegs, MetaDescription, MetaTitle, MetaKeyword, IdBrand, Id_lang, Id_category, Price, Id_discont, Availability, Id_current, MinQunt, DateAdd')->where(['IdBrand' => $idBrand, 'Status' =>10]);
                    $item = Products::find()->select('Id, Name')->where(['Id' => $data->IdProduct])->one();


                    return $item->Name;
                    //echo $data->IdProduct;
                },

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $item = Products::find()->select('Id, Name')->where(['Id' => $model->IdProduct])->one();

                        $url = Url::current(['view', 'id' => $item->Id]);

                        //Для стилизации используем библиотеку иконок

                        return \yii\helpers\Html::a(
                            '<span class="mr-5">  &#128065;  </span>',
                            $url,
                            ['title' => Yii::t('yii', 'просмотр')]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>
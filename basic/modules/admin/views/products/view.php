<?php

use app\modules\admin\models\ProductImg;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\models\Products;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Products */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Товары'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>
<div class="products-view">

    <div class="d-flex justify-content-between">

        <h2 class="mt-5 pl-0"><?= Html::encode($this->title) . ' ' . $model->MetaTitle ?></h2>
        <a class="btn mt-5" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>
    <div class="row d-flex justify-content-around mb-3">
        <?= Html::a(Yii::t('app', 'Редактирование'), ['update', 'id' => $model->Id], ['class' => 'btn btn-success w-25']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->Id], [
            'class' => 'btn btn-danger w-25',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить этот товар?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?
$brand = $model->idBrand->Brand;
$lang = $model->lang->language;
$sale = $model->discont->Value_discont;
$current = $model->current->Name;
$category = $model->category->Name;
$imgDop = $model->productImgs;
$prodAll = $model->recommendProds;
?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'Id',
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
            ],
            'Name',
            [
                'attribute' => 'IdBrand',
                'value' => $brand
            ],
            'Description:html',
            'Description_ua:html',
            [
                'attribute' => 'Id_category',
                'value' => $category
            ],
            [
                'attribute' => 'Img',
                'value' =>  '@web/img/' . $model->Img,
                'format' => ['image', ['class' => 'img adminBrend rounded mx-auto d-block']],

            ],
            //   'Img',
            //'Img2',
            [
                'attribute' => 'Img2',
                'value' =>  '@web/img/' . $model->Img2,
                'format' => ['image', ['class' => 'img adminBrend rounded mx-auto d-block']],

            ],

            [
                'attribute' => 'Id_lang',
                'value' => $lang
            ],
            'Conventional_units',
            'Markup',

            'Price',
            [
                'attribute' => 'Id_current',
                'value' => $current
            ],
            [
                'attribute' => 'Id_discont',
                'value' => $sale
            ],
            'Availability',
            'MinQunt',
            'Units',
            'DateAdd',
            'Tegs',
            'MetaDescription',
            'MetaTitle',
            'MetaKeyword',
            'MetaDescription_ua',
            'MetaTitle_ua',
            'MetaKeyword_ua',
        ],
    ]) ?>
    <h4 class='text-center'>Дополнительные изображения товара <?= Html::a(Yii::t('app', 'Добавить/удалить изображение'), ['imgadd?id=' . $model->Id], ['class' => 'btn btn-success']) ?></h4>
    <p>

    </p>
    <div class='row'>
        <div class="d-flex justify-content-around m-3 col-sm-12">

            <?if (count($moreImg)==0):?>
            <p>Дополнительное изображение отсутствует...</p>
            <?endif?>

            <?foreach($imgDop as $item):?>
            <div class="col-sm-3">
                <?= Html::img('@web/img/' . $item['Img'], ['alt' => 'Product', 'class' => 'pic', 'width' => 280, 'height' => 180]) ?>

            </div>
            <?endforeach ?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h3 class="text-center  p-5">Аналоги</h3>

            <?= GridView::widget([
                'dataProvider' => $newAnalog,
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
                                case 1:
                                    return '0 %';
                                case 2:
                                    return '10 %';
                                case 3:
                                    return '15 %';
                                case 4:
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


            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h3 class="text-center  p-5">Рекомендованый товар <?= Html::a(Yii::t('app', 'Добавить рекомендованый товар'), ['itemadd?id=' . $model->Id], ['class' => 'btn btn-success']) ?></h3>


            <?= GridView::widget([
                'dataProvider' => $recomProd,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'Id_products',
                        'label' => 'Код товара',
                        'value' =>  function ($data) {
                            //  $item = $data->getIdProduct();
                            // $query = Products::find()->select(' Id, Name, Description, Img, Img2, Tegs, MetaDescription, MetaTitle, MetaKeyword, IdBrand, Id_lang, Id_category, Price, Id_discont, Availability, Id_current, MinQunt, DateAdd')->where(['IdBrand' => $idBrand, 'Status' =>10]);
                            $item = Products::find()->select('Id, Name')->where(['Id' => $data->Id_recomend])->one();


                            return $item->Name;
                            //echo $data->IdProduct;
                        },
                    ],
                    [
                        'attribute' => 'Id_products',
                        'label' => 'Описание',
                        'value' =>  function ($data) {
                            //  $item = $data->getIdProduct();
                            // $query = Products::find()->select(' Id, Name, Description, Img, Img2, Tegs, MetaDescription, MetaTitle, MetaKeyword, IdBrand, Id_lang, Id_category, Price, Id_discont, Availability, Id_current, MinQunt, DateAdd')->where(['IdBrand' => $idBrand, 'Status' =>10]);
                            $item = Products::find()->select('Id, Name,MetaTitle')->where(['Id' => $data->Id_recomend])->one();


                            return $item->MetaTitle;
                            //echo $data->IdProduct;
                        },
                    ],
                    [
                        'attribute' => 'Id_products',
                        'label' => 'Изображение',
                        'value' =>  function ($data) {
                            //  $item = $data->getIdProduct();
                            // $query = Products::find()->select(' Id, Name, Description, Img, Img2, Tegs, MetaDescription, MetaTitle, MetaKeyword, IdBrand, Id_lang, Id_category, Price, Id_discont, Availability, Id_current, MinQunt, DateAdd')->where(['IdBrand' => $idBrand, 'Status' =>10]);
                            $item = Products::find()->select('Id, Name, Img')->where(['Id' => $data->Id_recomend])->one();


                            return
                                Html::img('@web/img/' .  $item->Img, ['alt' => 'Product', 'class' => 'img adminBrend rounded mx-auto d-block']);

                            //echo $data->IdProduct;
                        },
                        'format' => 'html'

                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{delete}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                $item = Products::find()->select('Id, Name')->where(['Id' => $model->Id_recomend])->one();

                                $url = Url::current(['view', 'id' => $item->Id]);

                                //Для стилизации используем библиотеку иконок

                                return \yii\helpers\Html::a(
                                    '<span class="mr-5">  &#128065;  </span>',
                                    $url,
                                    ['title' => Yii::t('yii', 'просмотр')]
                                );
                            },
                            'delete' => function ($url, $model, $key) {
                                // $item = Products::find()->select('Id, Name')->where(['Id' => $model->Id_recomend])->one();

                                $url = Url::current(['delrecom', 'idrec' => $model->Id_recomend, 'id' => $model->Id_products]);

                                //Для стилизации используем библиотеку иконок

                                return \yii\helpers\Html::a(
                                    '<span class="mr-5">  	&#128465;  </span>',
                                    $url,
                                    ['title' => Yii::t('yii', 'удалить')]
                                );
                            },
                        ],

                    ],
                ]
            ]) ?>
        </div>

    </div>

</div>




</div>
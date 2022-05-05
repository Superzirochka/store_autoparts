<?php
/*
 * Страница списка товаров категории, файл modules/admin/views/category/products.php
 */

use app\models\Category as ModelsCategory;
use mihaildev\ckeditor\CKEditor;
use app\modules\admin\models\BrandProd;
use app\modules\admin\models\Category;
use app\modules\admin\models\Discont;
use app\modules\admin\models\ManufacturerAuto;
use app\modules\admin\models\Products;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $category app\modules\admin\models\Category  */
/* @var $products yii\data\ActiveDataProvider */

$this->title = 'Модели : ' . $marka->Marka;
//$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Марки автомобилей'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="d-flex justify-content-between">
        <h2 class="mt-3"><?= Html::encode($this->title) ?></h2>
    </div>
</div>
<div class="row mb-3">
    <div class="col-sm-3">

        <?=
            Html::a(
                'Добавить модель',
                ['createmodel', 'idMarka' => $id],
                ['class' => 'btn btn-success']
            );
        ?>
    </div>
    <div class="col-sm-8"></div>
    <div class="col-sm-1">
        <a class="btn" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>

</div>
<div class="row">
    <div class="col-sm-12">

        <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table text-white mt-3'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'Id',

                    // [
                    //     'attribute' => 'IdManufacturer',
                    //     'value' => function ($data) {
                    //         $categ = ManufacturerAuto::find()->where(['Id' => $data->IdManufacturer])->one();
                    //         //var_dump($categ[0]['Name']);
                    //         //return $data->Id_category;
                    //         return $categ->Marka;
                    //     }

                    // ],
                    'ModelName',
                    'constructioninterval',
                    [
                        'attribute' => 'Img',
                        'contentOptions' => ['class' => 'table_class'],
                        'content' => function ($data) {
                            if (empty($data->Img)) {
                                return
                                    Html::img('@web/img/defultLogo.jpg', ['alt' => $data->ModelName, 'class' => 'img adminBrend rounded mx-auto d-block']);
                            } else {
                                return
                                    Html::img('@web/img/marks/' . $data->Img, ['alt' => $data->ModelName, 'class' => 'img adminBrend rounded mx-auto d-block']);
                            }
                        },
                        'filter' => false,
                    ],
                    [
                        'attribute' => 'FullName',
                        'filter' => false
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{modication}{update}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                // $item = ModelAuto::find()->select('Id, IdManufacturer, ModelName, FullName, constructioninterval')->where(['IdManufacturer' => $model->Id])->one();

                                $url = Url::current(['updatemodel', 'id' => $model->Id]);

                                //Для стилизации используем библиотеку иконок

                                return \yii\helpers\Html::a(
                                    '<span class="glyphicon glyphicon-pencil"> </span>',
                                    $url,
                                    ['title' => Yii::t('yii', 'Редактировать модель')]
                                );
                            },
                            'modication' => function ($url, $model, $key) {
                                // $item = ModelAuto::find()->select('Id, IdManufacturer, ModelName, FullName, constructioninterval')->where(['IdManufacturer' => $model->Id])->one();

                                $url = Url::current(['modification', 'id' => $model->Id, 'idmarka' => $model->IdManufacturer]);

                                //Для стилизации используем библиотеку иконок

                                return \yii\helpers\Html::a(
                                    '<span class="glyphicon glyphicon-list"> </span>',
                                    $url,
                                    ['title' => Yii::t('yii', 'Модификация модели')]
                                );
                            },

                        ],
                    ],
                ],

            ]);
        ?>
    </div>
</div>
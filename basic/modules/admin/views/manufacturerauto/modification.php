<?php
/*
 * Страница списка товаров категории, файл modules/admin/views/category/products.php
 */

use app\models\Category as ModelsCategory;
use mihaildev\ckeditor\CKEditor;
use app\modules\admin\models\BrandProd;
use app\modules\admin\models\Category;
use app\modules\admin\models\Discont;
use app\modules\admin\models\Engine;
use app\modules\admin\models\ManufacturerAuto;
use app\modules\admin\models\Products;
use app\modules\admin\models\ValueEngine;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $category app\modules\admin\models\Category  */
/* @var $products yii\data\ActiveDataProvider */

$this->title = 'Модификации автомобиля : ' . $modelAuto->FullName;
//$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Марки автомобилей'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Модели ' . $modelAuto->FullName), 'url' => ['modelsauto', 'id' => $modelAuto->IdManufacturer]];
$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="d-flex justify-content-between">
        <h2 class="mt-3"><?= Html::encode($this->title) . ' ' . $modelAuto->constructioninterval ?></h2>
    </div>
</div>
<div class="row mb-3">
    <div class="col-sm-3">

        <?=
            Html::a(
                'Добавить модификацию',
                ['createmodific', 'idModel' => $modelAuto->Id],
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
                    'Id', //код модификации
                    //  ' IdModelAuto',
                    [
                        'attribute' =>  'IdEngine',
                        'value' =>  function ($data) {
                            $engine = Engine::find()->where(['Id' => $data->IdEngine])->one();
                            return $engine->Name;
                        },
                        'filter' => Engine::getParentsList(),
                    ],
                    [
                        'attribute' =>  'IdValueEngine',
                        'value' =>  function ($data) {
                            $engine = ValueEngine::find()->where(['Id' => $data->IdValueEngine])->one();
                            return $engine->Value;
                        }, //Country::country()
                        'filter' => ValueEngine::getParentsList(),
                        // ValueEngine::value($searchModel),
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{oem}',
                        'buttons' => [
                            'oem' => function ($url, $model, $key) {
                                // $item = ModelAuto::find()->select('Id, IdManufacturer, ModelName, FullName, constructioninterval')->where(['IdManufacturer' => $model->Id])->one();

                                $url = Url::current(['oem', 'idmodif' => $model->Id]);

                                //Для стилизации используем библиотеку иконок

                                return \yii\helpers\Html::a(
                                    '<span > &#9881; </span>',
                                    $url,
                                    ['title' => Yii::t('yii', 'Оригинальные номера')]
                                );
                            },
                            // 'products' => function ($url, $model, $key) {
                            //     // $item = ModelAuto::find()->select('Id, IdManufacturer, ModelName, FullName, constructioninterval')->where(['IdManufacturer' => $model->Id])->one();

                            //     $url = Url::current(['modification', 'id' => $model->Id, 'idmarka' => $model->IdManufacturer]);

                            //     //Для стилизации используем библиотеку иконок

                            //     return \yii\helpers\Html::a(
                            //         '<span class="glyphicon glyphicon-list"> </span>',
                            //         $url,
                            //         ['title' => Yii::t('yii', 'Модификация модели')]
                            //     );
                            // },

                        ],
                    ],
                ],

            ]);
        ?>
    </div>
</div>
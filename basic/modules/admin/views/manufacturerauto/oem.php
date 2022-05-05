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
use app\modules\admin\models\ModelAuto;
use app\modules\admin\models\NodeAuto;
use app\modules\admin\models\Products;
use app\modules\admin\models\ValueEngine;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $category app\modules\admin\models\Category  */
/* @var $products yii\data\ActiveDataProvider */

$this->title = 'Оригинальные номера автомобиля : ' . $modelAuto->FullName;
//$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Марки автомобилей'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Модели ' . $modelAuto->FullName), 'url' => ['modelsauto', 'id' => $modelAuto->IdManufacturer]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Модификация'), 'url' => ['modification', 'id' => $modelAuto->Id, 'marka' => $modelAuto->IdManufacturer]];
$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
?>
<?//var_dump( $modelAuto)?>
<div class="row">
    <div class="d-flex justify-content-between">
        <h2 class="mt-3"><?= Html::encode($this->title) . ' ' . $modelAuto->constructioninterval ?></h2>
    </div>
</div>
<div class="row mb-3">
    <div class="col-sm-3">
        <?
//print_r($modific)
?>
        <?=
            Html::a(
                'Добавить OEM',
                ['createoem', 'idModif' => $modific->Id],
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
        <?
$m=$modelAuto->FullName;
?>
        <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table text-white mt-3'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // 'Id', //код модификации
                    'OEM',
                    'Description:text',
                    [
                        'attribute' =>  'IdNode',
                        'value' =>  function ($data) {
                            $engine = NodeAuto::find()->where(['Id' => $data->IdNode])->one();
                            return $engine->Node;
                        },
                        'filter' => NodeAuto::getTree(),
                    ],
                    //'Description_ua:html',
                    //'Description:html',
                    // [
                    //     'attribute' => 'Img',
                    //     'contentOptions' => ['class' => 'table_class'],
                    //     'content' => function ($data) {
                    //         if (empty($data->Img)) {
                    //             return 'отсутствует';
                    //         } else {
                    //             return
                    //                 Html::img('@web/img/' . $data->Img, ['alt' => 'Node', 'class' => 'img adminBrend rounded mx-auto d-block']);
                    //         }
                    //     },

                    // ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{look}{update}{search}{analog}',
                        'buttons' => [
                            'search' => function ($url, $model, $key) {
                                // $item = ModelAuto::find()->select('Id, IdManufacturer, ModelName, FullName, constructioninterval')->where(['IdManufacturer' => $model->Id_auto])->one();

                                $url = Url::current(['products', 'OEM' => $model->OEM]);

                                //Для стилизации используем библиотеку иконок

                                return \yii\helpers\Html::a(
                                    '<span > 	&#128269;</span>',
                                    $url,
                                    ['title' => Yii::t('yii', 'Товар OEM')]
                                );
                            },
                            'look' => function ($url, $model, $key) {
                                // $item = ModelAuto::find()->select('Id, IdManufacturer, ModelName, FullName, constructioninterval')->where(['IdManufacturer' => $model->Id_auto])->one();

                                $url = Url::current(['viewoem', 'id' => $model->Id]);

                                //Для стилизации используем библиотеку иконок

                                return \yii\helpers\Html::a(
                                    '<span > &#128065;</span>',
                                    $url,
                                    ['title' => Yii::t('yii', 'Просмотр')]
                                );
                            },
                            'update' => function ($url, $model, $key) {
                                // $item = ModelAuto::find()->select('Id, IdManufacturer, ModelName, FullName, constructioninterval')->where(['IdManufacturer' => $model->Id])->one();

                                $url = Url::current(['updateoem', 'id' => $model->Id]);

                                //Для стилизации используем библиотеку иконок

                                return \yii\helpers\Html::a(
                                    '<span > &#128393;</span>',
                                    $url,
                                    ['title' => Yii::t('yii', 'Редактирование')]
                                );
                            },
                            'analog' => function ($url, $model, $key) {
                                // $item = ModelAuto::find()->select('Id, IdManufacturer, ModelName, FullName, constructioninterval')->where(['IdManufacturer' => $model->Id])->one();

                                $url = Url::current(['..\analog', 'oem' => $model->OEM]);

                                //Для стилизации используем библиотеку иконок

                                return \yii\helpers\Html::a(
                                    '<span > &#128464;</span>',
                                    $url,
                                    ['title' => Yii::t('yii', 'Аналоги')]
                                );
                            },

                        ],
                    ],
                ],

            ]);
        ?>
    </div>
</div>
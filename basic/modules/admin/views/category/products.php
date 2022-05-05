<?php
/*
 * Страница списка товаров категории, файл modules/admin/views/category/products.php
 */

use app\models\Category as ModelsCategory;
use mihaildev\ckeditor\CKEditor;
use app\modules\admin\models\BrandProd;
use app\modules\admin\models\Category;
use app\modules\admin\models\Discont;
use app\modules\admin\models\Products;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $category app\modules\admin\models\Category  */
/* @var $products yii\data\ActiveDataProvider */

$this->title = 'Товары категории: ' . $category->Name;
//$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Товары'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
                'Добавить товар',
                ['../admin/products/create'],
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
                'dataProvider' => $products,
                'tableOptions' => ['class' => 'table text-white mt-3'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'Id_category',
                        'value' => function ($data) {
                            $categ = ModelsCategory::find()->where(['Id' => $data->Id_category])->asArray()->all();
                            //var_dump($categ[0]['Name']);
                            //return $data->Id_category;
                            return $categ[0]['Name'];
                        }

                    ],
                    'Name',
                    'Description',
                    [
                        'attribute' => 'IdBrand',
                        'value' => function ($data) {
                            $brand = BrandProd::find()->where(['Id' => $data->IdBrand])->asArray()->all();
                            return $brand[0]['Brand'];
                        }
                    ],
                    'Price',
                    [
                        'attribute' => 'Id_discont',
                        'value' => function ($data) {
                            $discont = Discont::find()->where(['Id' => $data->IdBrand])->asArray()->all();
                            return $discont[0]['Value_discont'];
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'urlCreator' => function ($action, $model, $key, $index) {
                            return Url::to(['/admin/products/' . $action, 'id' => $model->Id]);
                        }
                    ],
                ],

            ]);
        ?>
    </div>
</div>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\Supplier;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ZakazProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Заказные товары');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakaz-products-index">
    <div class="d-flex justify-content-between">
        <h1><?= Html::encode($this->title) ?></h1>

        <p class="mt-4">
            <?= Html::a(Yii::t('app', 'Добавить товар'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <p class="mt-4">
            <?= Html::a(Yii::t('app', 'Загрузить из файла'), ['exseladd'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'filter' =>
                Supplier::find()->select('Supplier')->indexBy('Id')->orderBy('Supplier ASC')
                    ->column()
                //  ->all()
                ,
            ],
            'Brand',
            'ProductName',
            'Description',
            'EntryPrice',
            'Markup',
            //'Price',
            //'TermsDelive',
            //'Img',
            //'Count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
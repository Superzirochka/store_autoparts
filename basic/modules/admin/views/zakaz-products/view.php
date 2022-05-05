<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\models\Supplier;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ZakazProducts */

$this->title = $model->ProductName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заказные товары'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$item = Supplier::find()->select('Id, Supplier')->where(['Id' => $model->Supplier])->one();
?>
<div class="zakaz-products-view">

    <h1><?= Html::encode($this->title) ?> Поставщик: <i><?= $item->Supplier ?></i></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->Id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы действительно хотите удалить данную позицию?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            ],
            'Brand',
            'ProductName',
            'Description',
            'EntryPrice',
            'Markup',
            'Price',
            'TermsDelive',
            [
                'attribute' => 'Img',
                'value' =>  $model->Img,
                'format' => ['image', ['class' => 'img adminBrend rounded mx-auto d-block']],

            ],
            'Count',
        ],
    ]) ?>

</div>
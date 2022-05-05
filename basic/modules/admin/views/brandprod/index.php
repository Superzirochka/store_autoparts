<?php


use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\BrandProd;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Бренды');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-prod-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить бренд'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-sm table-bordered table-hover '
        ],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'Brand',
                'contentOptions' => ['class' => 'table text-white adminRow'],
                'filter' => BrandProd::find()->select('Brand', 'Id')->all(),

            ],
            //'Brand',
            //'Img',
            [
                'attribute' => 'Img',
                'contentOptions' => ['class' => 'table_class'],
                'content' => function ($data) {
                    return
                        Html::img('@web/img/' . $data->Img, ['alt' => 'Product', 'class' => 'img adminBrend rounded mx-auto d-block']);
                },

            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
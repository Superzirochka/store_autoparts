<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Акции');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actions-index ml-3">

    <h1 class="ml-3"><?= Html::encode($this->title) ?></h1>

    <p class="ml-3">
        <?= Html::a(Yii::t('app', 'Cоздать акцию'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row ml-3">
        <div class="col-sm-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'Id',
                    'Name',
                    //'Slug',
                    //'Content:ntext',
                    [
                        'attribute' => 'Img',
                        'contentOptions' => ['class' => 'table_class'],
                        'content' => function ($data) {
                            return
                                Html::img('@web/img/' . $data->Img, ['alt' => 'Product', 'class' => 'img adminBrend rounded mx-auto d-block']);
                        }
                    ],
                    //'Img',
                    //'KeyWord',
                    //'MetaDescription',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
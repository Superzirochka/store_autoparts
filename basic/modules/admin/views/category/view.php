<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Category */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Категории'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">
    <div class="d-flex justify-content-between">
        <h1><?= Html::encode($this->title) ?></h1>
        <a class="btn mt-5" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>
    <?
$lang = $model->lang->language;
$parentCategory = $model->parentCategory->Name;
$nodeauto = $model->node->Node;
?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //  'Id',
            [
                'attribute' => 'Id_lang',
                'value' => $lang
            ],
            'Name',
            'Description',
            'MetaDescription',
            'MetaTitle',
            'MetaKeyword',
            //'Img',
            [
                'attribute' => 'Img',
                'value' =>  '@web/img/' . $model->Img,
                'format' => ['image', ['class' => 'img adminBrend rounded mx-auto d-block']],

            ],
            [
                'attribute' => 'Id_parentCategory',
                'value' => $parentCategory
            ],
            [
                'attribute' => 'id_node',
                'value' => $nodeauto
            ]
        ],
    ]) ?>
    <div class="d-flex justify-content-around">

        <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->Id], ['class' => 'btn btn-success w-25']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->Id], [
            'class' => 'btn btn-danger w-25',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить эту категорию?'),
                'method' => 'post',
            ],
        ]) ?>


    </div>
</div>
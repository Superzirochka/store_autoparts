<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Page */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Страницы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-view">

    <div class="d-flex justify-content-between">
        <h2 class="mt-3"><?= Html::encode($this->title) ?></h2>
        <a class="btn mt-3" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>
    <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->Id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->Id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить этоту страницу?'),
            'method' => 'post',
        ],
    ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'Id',
            // 'parent_id',
            [
                'attribute' => 'parent_id',
                'value' =>  $model->getParentName()
            ],
            'Name',
            'Name_ua',
            'Slug',
            [
                'attribute' => 'Content',
                'value' =>  empty($model->Content) ? 'Не задано' : $model->Content,
                'format' => 'html'
            ],
            //'Content:html',
            //'Content_ua:html',
            [
                'attribute' => 'Content_ua',
                'value' =>  empty($model->Content_ua) ? 'Не задано' : $model->Content_ua,
                'format' => 'html'
            ],
            [
                'attribute' => 'Keywords',
                'value' =>  empty($model->Keywords) ? 'Не задано' : $model->Keywords
            ],
            [
                'attribute' => 'Description',
                'value' =>  empty($model->Description) ? 'Не задано' : $model->Description
            ],
            [
                'attribute' => 'Keywords_ua',
                'value' =>  empty($model->Keywords_ua) ? 'Не задано' : $model->Keywords_ua
            ],
            [
                'attribute' => 'Description_ua',
                'value' =>  empty($model->Description_ua) ? 'Не задано' : $model->Description_ua
            ],
            //'Keywords',
            //  'Keywords_ua',
            //'Description',
            //  'Description_ua',
        ],
    ]) ?>

</div>
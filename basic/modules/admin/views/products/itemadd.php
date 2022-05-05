<?php

use mihaildev\ckeditor\CKEditor;


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Добавить рекомендованый товар для ' . $Name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app',  $Name), 'url' => ['view?id=' . $id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div>
    <div class="d-flex justify-content-between">

        <h2 class="mt-5 pl-0"><?= $Name ?></h2>
        <a class="btn mt-5" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formitem', [
        'model' => $model,
    ]) ?>






</div>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ManufacturerAuto */

$this->title = Yii::t('app', 'Редактировать OEM') . ' ' . $modelAuto->FullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Марки автомобилей'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Модификация'), 'url' => ['modification', 'id' => $modelAuto->Id, 'marka' => $modelAuto->IdManufacturer]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacturer-auto-create">

    <h1><?= Html::encode($this->title) . ' ' . $modelAuto->constructioninterval ?></h1>

    <?= $this->render('_formOem', [
        'model' => $model,
    ]) ?>

</div>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ManufacturerAuto */

$this->title = Yii::t('app', 'Добавить модель') . ' ' . $marka;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Марки автомобилей'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Модели'), 'url' => ['modelsauto', 'id' => $model->IdManufacturer]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacturer-auto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formModel', [
        'model' => $model,
    ]) ?>

</div>
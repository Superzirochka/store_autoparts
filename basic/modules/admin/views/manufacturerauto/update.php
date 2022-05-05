<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ManufacturerAuto */

$this->title = Yii::t('app', 'Редактирование марки: {name}', [
    'name' => $model->Marka,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Марки автомобилей'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Marka, 'url' => ['view', 'id' => $model->Id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактировать');
?>
<div class="manufacturer-auto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
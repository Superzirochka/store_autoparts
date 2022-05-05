<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ZakazProducts */

$this->title = Yii::t('app', 'Редактирование: {name}', [
    'name' => $model->ProductName,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заказные товары'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProductName, 'url' => ['view', 'id' => $model->Id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактирование');
?>
<div class="zakaz-products-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
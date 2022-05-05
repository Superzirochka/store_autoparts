<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Supplier */

$this->title = Yii::t('app', 'Редактировать: {name}', [
    'name' => $model->Supplier,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Поставщики'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Supplier, 'url' => ['view', 'id' => $model->Id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактировать');
?>
<div class="supplier-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
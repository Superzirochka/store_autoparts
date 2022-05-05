<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BrandProd */

$this->title = Yii::t('app', 'Обновить бренд: {name}', [
    'name' => $model->Brand,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Бренд'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Brand, 'url' => ['view', 'id' => $model->Id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактировать');
?>
<div class="brand-prod-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
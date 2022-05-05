<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Store */

$this->title = Yii::t('app', 'Обновление магазина: {name}', [
    'name' => $model->Name_shop,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Магазины'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Name_shop, 'url' => ['view', 'id' => $model->Id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Обновление');
?>
<div class="store-update ml-3">

    <h2 class="ml-3
    "><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
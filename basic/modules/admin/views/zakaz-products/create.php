<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ZakazProducts */

$this->title = Yii::t('app', 'Добавить товара');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заказной товар'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakaz-products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
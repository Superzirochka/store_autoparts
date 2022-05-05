<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BrandProd */

$this->title = Yii::t('app', 'Обновить : {name}', [
    'name' => $model->OEM,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Аналоги'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->params['breadcrumbs'][] = Yii::t('app', 'Редактировать');
?>
<div class="brand-prod-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
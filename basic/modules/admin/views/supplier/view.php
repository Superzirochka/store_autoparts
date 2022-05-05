<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Supplier */

$this->title = $model->Supplier;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Поставщики'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="supplier-view">

<div class="d-flex justify-content-between">
    <h2><?= Html::encode($this->title) ?></h2>
 <a class="btn mt-3" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>
    <p>
        <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->Id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы действитьельно хотите удалить поставщика?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Id',
            'Supplier',
        ],
    ]) ?>

</div>
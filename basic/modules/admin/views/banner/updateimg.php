<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\BannerImg;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Редактирование изображения');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Слайдеры'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', $this->title);
?>
<div class="banner-updateimg">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formaddimg', [
        'model' => $model,
    ]) ?>
</div>
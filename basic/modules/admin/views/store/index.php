<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Магазины');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить магазин'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'Id',
            'Name_shop',
            'Description',
            'Meta_title',
            'Meta_description',
            //'Meta_keyword',
            //'Phone',
            //'Viber',
            //'Facebook_link',
            //'Work_time',
            //'Email:email',
            //'Adress',
            //'Date_add',
            //'Owner',
            //'Telegram_link',
            //'Google_map',
            //'Logo',
            //'logo_small',
            //'Id_lang',
            //'About',
            //'Dostavka:ntext',
            //'Oplata:ntext',
            //'Vozvrat:ntext',
            //'Confiden:ntext',
            //'Description_ua',
            //'Meta_title_ua',
            //'Meta_description_ua',
            //'Meta_keyword_ua',
            //'Work_time_ua',
            //'Adress_ua',           

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
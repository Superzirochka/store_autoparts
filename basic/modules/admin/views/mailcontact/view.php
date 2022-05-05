<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\MailContact */

$this->title = 'Сообщение';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Сообщения'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mail-contact-view">

    <div class="d-flex justify-content-between">
        <h2><?= Html::encode($this->title) ?></h2>
        <a class="btn mt-3" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->Id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены что хотите удалить сообщение от ' . $model->DateAdd . ' отправитель ' . $model->FIO . '?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'Id',
            'FIO',
            'TitleMessage',
            'Message',
            'Email:email',
            [
                'attribute' => 'Status',
                'value' =>  function ($data) {
                    switch ($data->Status) {
                        case 'new':
                            return '<span class="text-danger">Новый</span>';
                        case 'processed':
                            return '<span class="text-warning">В работе</span>';
                        case 'considered':
                            return '<span class="text-warning">Рассмотрен</span>';
                        case 'completed':
                            return '<span class="text-success">Завершен</span>';
                        case 'delete':
                            return '<span class="text-success">Удалено</span>';
                        default:
                            return 'Ошибка';
                    }
                },
                'format' => 'html'
            ],
            'DateAdd',
        ],
    ]) ?>
    <h2 class='m-3'>Ответы</h2>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'Title',
            'Text',
            'DateAnswer',

        ],
    ]); ?>

</div>
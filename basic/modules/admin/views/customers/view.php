<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Customers */

$this->title = $model->FName . ' ' . $model->LName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Покупатели'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);



?>
<div class="customers-view">

    <div class="d-flex justify-content-between">
        <h1><?= Html::encode($this->title) ?></h1>
        <a class="btn mt-5" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //  'Id',
            'Login',
            'FName',
            'LName',
            'Email:email',
            'Phone',
            // 'Password',
            //'News',
            [
                'attribute' => 'News',
                'value' =>  function ($data) {
                    switch ($data->News) {
                        case '1':
                            return 'Подписка оформлена';
                        case '0':
                            return 'Отказ от подписки';

                        default:
                            return 'Ошибка';
                    }
                },
            ],
            'City',
            'Adres',
            // 'IdGruop',
            [
                'attribute' => 'IdGruop',
                'value' =>  function ($data) {
                    switch ($data->IdGruop) {
                        case '1':
                            return 'Гость';
                        case '2':
                            return 'Постоянный клиент';
                        case '3':
                            return 'VIP клиент';

                        default:
                            return 'Ошибка';
                    }
                },
            ],
            [
                'attribute' => 'Status',
                'value' =>  function ($data) {
                    switch ($data->Status) {
                        case '10':
                            return 'Активный';
                        case '0':
                            return 'Удален';

                        default:
                            return 'Ошибка';
                    }
                },
            ],
            //'hash',
            //  'password_reset_token',
            //'Status',
            'DateRegistration',
        ],
    ]) ?>

    <div class="d-flex justify-content-around">
        <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->Id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить покупателя' . $model->FName . ' ' . $model->LName . '?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

</div>
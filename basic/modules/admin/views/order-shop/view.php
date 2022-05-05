<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\models\Supplier;
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\OrdersShop */

$this->title = 'Просмотр заказа № ' . $model->OrderNumber;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заказы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-shop-view">

    <div class="d-flex justify-content-between">
        <h2 class="ml-3 mt-3"><?= "Заказ № " . $model->OrderNumber ?></h2>
        <a class="btn mt-3" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <h4 class="mt-3 mb-3"> Информация о заказе</h4>
            <?php
            $products = $model->items;
            $oplata = $model->oplata->Name;
            $dostavka = $model->dostavka->Name;
            ?>

            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th>Поставщик</th>
                    <th>Бренд</th>
                    <th>Наименование</th>
                    <th>Наличие</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Сумма</th>
                </tr>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td class="text-right">
                            <?
                                                $suplier = Supplier::findOne($product->Supplier);
                                               echo   $suplier->Supplier; ?>
                        </td>
                        <td class="text-right"><?= $product->Brand; ?></td>
                        <td><?= $product->Name;
                            ?></td>
                        <td class="text-right"><?= $product->Availability; ?></td>
                        <td class="text-right"><?= $product->Quanty; ?></td>
                        <td class="text-right"><?= $product->Price; ?></td>
                        <td class="text-right"><?= $product->Cost; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th colspan="4" class="text-right">Итого</th>
                    <th colspan="3" class="text-right"><?= $model->Amount; ?></th>
                </tr>
            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-sm-12">
            <h4 class="mt-3 mb-3"> Состояние заказа</h4>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'OrderNumber',
                    [
                        'attribute' => 'Status',
                        'value' =>  function ($data) {
                            switch ($data->Status) {
                                case 'new':
                                    return 'Новый !!!';
                                case 'processed':
                                    return 'Обработан';
                                case 'paid':
                                    return 'Оплачен';
                                case 'delivered':
                                    return 'Доставлен';
                                case 'completed':
                                    return 'Завершен';
                                default:
                                    return 'Ошибка';
                            }
                        },
                    ],
                    'DateAdd',
                    'DateUpdate',

                ],
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mt-3 mb-3"> Информация о клиенте</h4>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'Name',
                    'LastName',
                    'Email:email',
                    'Phone',
                    [
                        'attribute' => 'Mailing',
                        'value' =>  function ($data) {
                            switch ($data->Mailing) {
                                case 0:
                                    return 'отказ от рассылки';
                                case 1:
                                    return 'Подписан на рассылку';
                                default:
                                    return 'Ошибка';
                            }
                        },
                    ],


                ],
            ]) ?>
        </div>
        <div class="col-sm-6">

            <h4 class="mt-3 mb-3"> Информация о доставке и оплате</h4>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'IdDostavka',
                        'value' => $dostavka
                    ],
                    'City',
                    'Adress',
                    'Comment',

                    [
                        'attribute' => 'IdOplata',
                        'value' => $oplata
                    ]
                ],
            ]) ?>
        </div>
    </div>

    <div class="row d-flex justify-content-around">
        <?= Html::a(Yii::t('app', 'Изменить'), ['update', 'id' => $model->Id], ['class' => 'btn btn-primary btn-lg w-25']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->Id], [
            'class' => 'btn btn-danger btn-lg w-25',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены что хотите удалить заказ № ' . $model->OrderNumber . ' ?'),
                'method' => 'post',
            ],
        ]) ?>

    </div>



</div>
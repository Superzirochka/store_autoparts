<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Products;
use app\models\Wishlist;
use app\models\Carts;



$this->title = 'Список желаний';
$this->params['breadcrumbs'][] = $this->title;
$today = date("Y-m-d");

// $session = Yii::$app->session;
// $session->open();
// if (!$session->has('wish_auto')) {
//     $session->set('wish_auto', []);
//     $wishlist = [];
// } else {
//     $wishlist = $session->get('wish_auto');
// }

// $query = Products::find()->select('Id, Name, Description, Img, Img2, MetaDescription, MetaTitle, MetaKeyword, IdBrand, Id_lang, Id_category, Price, Id_discont, Availability, Id_current, MinQunt')->orderBy('Name DESC')->all();

// if (count($wishlist) == 0) {
//     $messageWish = 'Ваш список желаний пуст';
// }

// $products = [];
// if (count($wishlist) != 0) {
//     foreach ($wishlist['products'] as $list) {
//         foreach ($query as $items) {
//             if ($list['Id'] == $items->Id) {
//                 array_push($products, $items);
//             }
//         }
//     }
// }
?>
<div class="container my-shadow " id="content_box">
    <div class="row">
        <div class="col-md-3">
            <?= app\components\CategoryWidget::widget() ?>
            <!-- <?= app\components\BrandWidget::widget() ?> -->
        </div>
        <div class="col-md-9">
            <?= app\components\AutobrendWidget::widget() ?>


            <div class="Wishlist-area mb-5">
                <h2 class="text-center mb-5 mt-2"><?= $this->title ?></h2>
                <h3 class="text-center mb-3"><?= $messageWish ?></h3>
                <? if ($messageWish == '') : ?>
                    <div class="table-responsive-sm">

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center">Изображение</td>
                                    <td class="text-center">Код товара</td>
                                    <td class="text-center">Название</td>
                                    <td class="text-center">Минимальный заказ</td>
                                    <td class="text-center">Цена</td>
                                    <td class="text-right"></td>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($products as $item) : ?>
                                    <tr>
                                        <td class="text-center align-middle">
                                            <a href="#"><?= Html::img('@web/img/' . $item->Img, ['alt' => 'Product', 'width' => '50px']) ?></a>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $item->Id]) ?>"><?= $item->Name ?></a>
                                        </td>
                                        <td class="text-center align-middle"><?= $item->MetaDescription ?></td>
                                        <td class="text-center align-middle"><?= $item->MinQunt ?></td>
                                        <td class="text-center align-middle">

                                            <span><?= $item->Price ?> <?= $current->Name ?></span>

                                        </td>
                                        <td class="align-middle text-center">
                                            <? if ($item->Status == 10) : ?>
                                                <a href="<?= yii\helpers\Url::to(['autoshop/wishlist', 'id' => $item->Id, 'add' => 'add']) ?> " type="button" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="Add to Cart">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </a>
                                            <? endif ?>
                                            <a href="<?= yii\helpers\Url::to(['autoshop/wishlist', 'id' => $item->Id, 'del' => 'delete']) ?>" class="btn btn-danger" data-toggle="tooltip" title="" data-original-title="Remove">

                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <? endforeach ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-around">

                        <a href="<?= yii\helpers\Url::to(['autoshop/list']) ?>" class="btn w-25 btn-primary">Продолжить покупки</a>
                        <a href="<?= yii\helpers\Url::to(['autoshop/wishlist', 'clear' => 'clear']) ?>" class="btn  btn-danger w-25">Очистить список</a>
                    </div>
                <? else : ?>
                    <a href="<?= yii\helpers\Url::to(['autoshop/list']) ?>" class="btn btn-block btn-primary mt-5">Назад </a>
                <? endif ?>

            </div>

            <div class="row">
                <!--рекомендованный товар-->


                <?= app\components\Recomendprod::widget() ?>


            </div>
        </div>
    </div>
</div>
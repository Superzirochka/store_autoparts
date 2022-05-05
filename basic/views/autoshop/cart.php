<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\Products;
use app\models\Wishlist;
use app\models\Carts;
use app\models\ZakazProducts;
 

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
$today = date("Y-m-d");
if (empty($carts) || empty($carts['products']) && empty($carts['zakaz'])) {
    $textCart = ' Ваша корзина пуста';
} else {
    $textCart = '';
}
//$cartProduct = $basket;
?>
<div class="container my-shadow " id="content_box">
    <div class="row">
        <div class="col-md-3">
            <?= app\components\CategoryWidget::widget() ?>
            <!-- <?= app\components\BrandWidget::widget() ?> -->
        </div>
        <div class="col-md-9">
            <?= app\components\AutobrendWidget::widget() ?>
            <div class="product-area">
                <!-- Start Shopping-Cart -->
                <div class="shopping-cart">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="cart-title">
                                <h2 class="text-center"><?= $this->title ?></h2>

                                <h3 class="text-center mt-5"><?= $textCart ?></h3>
                            </div>
                            <!-- Start Table -->
                            <div class="table-responsive">
                                <? if (count($carts) != 0 ) : ?>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td class="text-center">Изображение</td>
                                            <td class="text-left">Код товара</td>
                                            <td class="text-left">Название</td>
                                            <td class="text-left">Наличие</td>
                                            <td class="text-left">Количество</td>
                                            <td class="text-right">Цена</td>
                                            <td class="text-right">Сумма</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?if (!empty($carts['products'])):?>
                                        <? foreach ($carts['products'] as $cart) : ?>
                                        <?  
                                                                               
                                          $img = Yii::getAlias('@webroot') . 'img/' . $cart->Img;
                                          if (is_file($img)) {
                                              $url = Yii::getAlias('@web') . 'img/' .$cart->Img;
                                              
                                          }else{
                                              $url= Yii::getAlias('@web') . 'img/products/defult_prodact.jpg';
                                          }
                                              ?>
                                        <? $item = Products::findOne($cart['Id']) ;      
                                                             
                                        $img = Yii::getAlias('@webroot') . '/img/' . $item->Img;
                                        if (is_file($img)) {
                                            $url = Yii::getAlias('@web') . '/img/' .$item->Img;
                                            
                                        }else{
                                            $url= Yii::getAlias('@web') . 'img/products/defult_prodact.jpg';
                                        }
                                      
                                        ?>
                                        <tr>
                                            <td class="text-center align-middle">
                                                <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $item->Id]) ?>">
                                                    <?= Html::img($url, ['alt' => 'Product',  'width' => '60px']) ?>
                                                </a>
                                            </td>
                                            <td class="text-left align-middle">
                                                <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $item->Id]) ?>" class="mycolor"><?= $cart['Name'] ?></a>
                                            </td>

                                            <td class="text-left align-middle "><?= $item->MetaDescription ?>

                                            </td>
                                            <td class="text-center align-middle">в наличии</td>
                                            <td class="text-left align-middle ">
                                                <div class="btn-block cart-put d-flex flex-row">
                                                    <?php $form = ActiveForm::begin(); ?>
                                                    <?= $form->field($up_form, 'quanty')->textInput(['value' => $cart['Quanty'], 'type' => 'number'])->label(' '); ?>
                                                    <p> Цена указана за <i> <?= $item->Units ?></i></p>
                                                    <?= $form->field($up_form, 'idB')->textInput(['value' => $cart['Id'], 'type' => 'hidden', 'class' => 'mb-0'])->label(' '); ?>
                                                    <?=
                                                    Html::hiddenInput(
                                                        Yii::$app->request->csrfParam,
                                                        Yii::$app->request->csrfToken
                                                    );
                                                    ?>
                                                    <?= Html::submitButton('<i class="fa fa-refresh"></i>', ['class' => 'btn w-5 mr-1 mt-0', 'id' => 'myBackgra']) ?>



                                                    <a href="<?= yii\helpers\Url::to(['autoshop/cart', 'id' => $item->Id, 'del' => 'delete']) ?>" class="btn btn-danger w-5 mt-0" data-toggle="tooltip" title="Remove" data-original-title="Remove">
                                                        <i class="fa fa-times"></i>
                                                    </a>

                                                    <?php ActiveForm::end(); ?>
                                                </div>
                                            </td>
                                            <td class="text-right align-middle"><b><?= $cart['Price'] ?> </b><i><?= $current['Name'] ?></i></td>
                                            <td class="text-right align-middle"><b>
                                                    <? //$sum += $Quanty * $item->Price 
                                                        ?>
                                                    <?= $cart['Price'] * $cart['Quanty'] ?>
                                                </b><i><?= $current['Name'] ?></i></td>
                                        </tr>
                                        <? endforeach ?>
                                        <?endif?>
                                        <?if (!empty($carts['zakaz'])):?>
                                        <?foreach($carts['zakaz'] as $cart):?>
                                        <?
                                             $zakaz=ZakazProducts::findOne($cart['Id']);        
                                                $img = Yii::getAlias($zakaz->Img);
                                                if (is_file($img)) {
                                              $url = Yii::getAlias($cart->Img);
                                              
                                           }
                                        
                                         
                                            ?>
                                        <tr>
                                            <td class="text-center align-middle">

                                                <?= Html::img($zakaz->Img, ['alt' => 'Product',  'width' => '60px']) ?>

                                            </td>
                                            <td class="text-left align-middle">
                                                <?= $cart['ProductName'] ?>
                                            </td>

                                            <td class="text-left align-middle "><?= $zakaz->Description ?>

                                            </td>
                                            <td class="text-center align-middle"><?= $zakaz->TermsDelive ?></td>
                                            <td class="text-left align-middle ">
                                                <div class="btn-block cart-put d-flex flex-row">
                                                    <?php $form = ActiveForm::begin(); ?>
                                                    <?= $form->field($up_form, 'quanty')->textInput(['value' => $cart['Quanty'], 'type' => 'number'])->label(' '); ?>

                                                    <?= $form->field($up_form, 'idz')->textInput(['value' => $cart['Id'], 'type' => 'hidden', 'class' => 'mb-0'])->label(' '); ?>
                                                    <?=
                                                    Html::hiddenInput(
                                                        Yii::$app->request->csrfParam,
                                                        Yii::$app->request->csrfToken
                                                    );
                                                    ?>
                                                    <?= Html::submitButton('<i class="fa fa-refresh"></i>', ['class' => 'btn w-5 mr-1 mt-0', 'id' => 'myBackgra']) ?>

                                                    <a href="<?= yii\helpers\Url::to([
                                                                    'autoshop/cart', 'id' => $cart['Id'],
                                                                    'Supplier' => $cart['Supplier'], 'Brand' => $cart['Brand'], 'delZakaz' => 'delete'
                                                                ]) ?>" class="btn btn-danger w-5 mt-0" data-toggle="tooltip" title="Remove" data-original-title="Remove">
                                                        <i class="fa fa-times"></i>
                                                    </a>

                                                    <?php ActiveForm::end(); ?>
                                                </div>
                                            </td>
                                            <td class="text-right align-middle"><b><?= $cart['Price'] ?> </b><i><?= $current['Name'] ?></i></td>
                                            <td class="text-right align-middle"><b>
                                                    <? //$sum += $Quanty * $item->Price 
                                                        ?>
                                                    <?= $cart['Price'] * $cart['Quanty'] ?>
                                                </b><i><?= $current['Name'] ?></i></td>
                                        </tr>
                                        <?endforeach?>
                                        <?endif?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-right" scope="col" colspan="5">
                                                <strong>Итого:</strong>
                                            </td>
                                            <td class="text-right" scope="col" colspan="2"><b><?= $carts['amount'] ?> </b><i> <?= $current['Name'] ?></i></td>
                                        </tr>
                                        </tr>
                                    </tfoot>
                                </table>
                                <? endif ?>
                            </div>
                            <!-- End Table -->



                            <div class="shopping-checkout d-flex justify-content-between">
                                <a href="#" class="btn btn-inline-block w-25" onclick=" javascript:history.back();" id="myBackgra">Продолжить покупки</a>
                                <? if ( $carts['amount']!=0) : ?>
                                <a href="<?= Url::to(['autoshop/cart', 'clear' => 'yes']); ?>" class="btn btn-danger">
                                    Очистить корзину
                                </a>
                                <a href="<?= yii\helpers\Url::to(['autoshop/order']) ?>" class="btn  btn-inline-block w-25" id="myBackgra">Оформить заказ</a>
                                <? endif ?>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Shopping-Cart -->
            </div>



        </div>
    </div>
</div>
<?php
/* @var $this yii\web\View */

use Codeception\Coverage\Subscriber\Printer;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Reviews;
use app\models\Carts;
use app\models\Wishlist;
use app\models\Products;
use app\models\RecommendProds;
use yii\widgets\ActiveForm;
use app\models\ProductImg;
use yii\widgets\Pjax;

$this->title = $item->MetaTitle;
$this->registerMetaTag(
    ['name' => 'ShopName', 'content' =>  Yii::$app->params['shopName']]
);
$this->registerMetaTag(
    ['name' => 'keywords', 'content' => $item->MetaKeyword]
);
$this->registerMetaTag(
    ['name' => 'description', 'content' => $item->MetaDescription . ' ' . Yii::$app->params['shopName']]
);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Все товары'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
$customer = Yii::$app->session->get('customer');
$idCustom = $customer['Id'];
$idses = 1;
$langSes = Yii::$app->session->get('lang');
$lang = $langSes['Id'];
$recItem = [];
$kursItem = $kurs->Current_kurs;
$prodAll = Products::find()->select(' Id, Name, Description, Img, Img2, MetaDescription, MetaTitle, MetaKeyword, IdBrand, Id_lang, Id_category, Price, Id_discont, Availability, Id_current, MinQunt, DateAdd, Tegs')->where(['Id_lang' => $lang])->orderBy('DateAdd DESC')->all();

$recommend = RecommendProds::find()->select('Id, Id_products, Id_recomend')->where(['Id_products' => $item->Id])->all();
foreach ($prodAll as $all) {
    foreach ($recommend as $rec) {
        if ($rec->Id_recomend ==  $all->Id) {
            array_push($recItem, $all);
        }
    }
}

//$img = $item->productImgs;
// ProductImg::find()->select('Id', 'IdProduct', 'Img')->where(['IdProduct' => $item->Id])->asArray()->all();

?>
<div class="container my-shadow " id="content_box">

    <div class="row">

        <div class="col-md-3">
            <?= app\components\CategoryWidget::widget() ?>
            <!-- <?= app\components\BrandWidget::widget() ?> -->

        </div>
        <div class="col-md-9">

            <!-- Start Toch-Prond-Area -->
            <div class="row">

                <div class=" col-sm-7 m-auto">
                    <div class="row">
                        <div id="wishView">
                            <?
                            $session = Yii::$app->session;
                            $session->open();
                            if (!$session->has('wish_auto')) {
                                $session->set('wish_auto', []);
                                $wishlist = [];
                            } else {
                                $wishlist = $session->get('wish_auto');
                            }
                            if (!($wishlist['products'][$item->Id])) :
                            ?>
                                <a href="<?= yii\helpers\Url::to(['autoshop/view', 'wish' => 'add', 'id' => $item->Id]) ?>" data-tip="Add to Wishlist" class="btn-outline-danger btn" title='Добавить в список желаний'>
                                    <i class="fa fa-lg fa-heart-o"></i>
                                </a>
                            <? else :  ?>
                                <a href="<?= yii\helpers\Url::to(['autoshop/view', 'wish' => 'del', 'id' => $item->Id]) ?>" data-tip="Del from Wishlist" class="btn-outline-danger btn" title='Удалить из списка желаний'>
                                    <i class="fa fa-lg fa-heart"></i>
                                </a>
                            <? endif ?>

                        </div>

                        <div class="product-image">
                            <? $imgMaster = Yii::getAlias('@webroot') . '/img/' . $item->Img;
                            //$imgProd='products/defult_prodact.jpg';
                            if (is_file($imgMaster)) {
                                $imgProd = Yii::getAlias('@web') . '/img/' . $item->Img;
                            } else {
                                $imgProd = Yii::getAlias('@web') . '/img/products/defult_prodact.jpg';
                            }
                            ?>

                            <a href="<?= $imgProd ?>" class="gallery2 toch-photo" data-fancybox="images">
                                <?= Html::img($imgProd, ['alt' => 'Product', 'data-imagezoom' => 'true', 'class' => 'picItem']) ?>

                            </a>

                        </div>

                    </div>

                    <div class="itemGallery">
                        <hr>
                        <?
                        $img2 = Yii::getAlias('@webroot') . '/img/' . $item->Img2;
                        ?>
                        <?
                        if (is_file($img2)) {
                            $imgProd2 = Yii::getAlias('@web') . '/img/' . $item->Img2;
                        } else {
                            $imgProd2 = Yii::getAlias('@web') . '/img/products/defult_prodact.jpg';
                        }


                        ?>
                        <a href="<?= $imgProd2 ?>" class="gallery2" rel="group" data-fancybox="images">
                            <?= Html::img($imgProd2, ['alt' => 'Product', 'data-imagezoom' => 'true', 'class' => 'picG']) ?>
                        </a>

                        <? if (count($img) !== 0) :
                        ?>
                            <? $count = count($img);

                            ?>
                            <? foreach ($img as $i) :
                            ?>

                                <a href="img/<?= $i->Img ?>" class="gallery2" rel="group" data-fancybox="images">
                                    <?= Html::img('@web/img/' .  $i->Img, ['alt' => 'Product', 'data-imagezoom' => 'true', 'class' => 'picG']) ?>

                                </a>

                                <?
                                $count--;
                                ?>

                            <? endforeach
                            ?>
                        <? endif
                        ?>
                        <a href="img/<?= $brend->Img ?>" class="gallery2" rel="group" data-fancybox="images">
                            <?= Html::img('@web/img/' . $brend->Img, ['alt' => 'Product', 'data-imagezoom' => 'true', 'class' => 'picG']) ?>
                        </a>


                        <hr>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mycolor">Описание товара</h4>
                            <hr>
                            <p class="card-text"> <?= $item->Description ?></p>

                        </div>

                        <div class="card-body">
                            <hr>
                            <? if (!$item->Tegs) {
                                $tegsName = '  нет дополнительных критериев для поиска';
                            } else {
                                $tegsName = $item->Tegs;
                            } ?>
                            <p>Теги поиска: <br><?= $tegsName ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="title-product"><?= $item->MetaTitle ?> </h1>
                            <h3>Код: <?= $item->Name ?></h3>
                            <p class="center">Производитель: <?= $brend->Brand ?></p>
                            <p>Категория :<a href="<?= yii\helpers\Url::to(['autoshop/list', 'idCat' => $item->Id_category, 'nameCategory' =>  $item->category->Name]) ?>" class="mycolor"> <?= $item->category->Name ?></a></p>
                        </div>

                    </div>
                    <!----- inform ---->

                    <hr />

                    <div class="about-product my-shadow">
                        <div class="current-price ">
                            <p>Цена: <span><i class="mycolor"> <?= $item->Price ?></i></span> <b><?= $current['Name'] ?></b></p>
                            <p class="text-danger">Цена указана за <?= $item->Units ?></p>
                        </div>
                        <div class="item-stock">
                            <i> Наличие:
                                <? if ($item->Status != 0) : ?>
                                    <b class="text-stock"><?= $item->Availability ?></b>
                                <? endif ?>
                            </i>
                            <br>
                            <i> Минимальный заказ: <b class="text-stock"><?= $item->MinQunt ?></b></i>
                        </div>

                        <? Pjax::begin([
                            // Опции Pjax
                        ]) ?>
                        <?php $form = ActiveForm::begin(['options' => ['class' => 'is-invalid', 'method' => 'POST', 'data' => ['pjax' => true]]]); ?>
                        <?= $form->field($form_quant, 'quant')->textInput(['placeholder' => $item->MinQunt, 'type' => 'number', 'value' => $item->MinQunt, 'id' => 'quant', 'autofocus' => true])->label('Количество'); ?>
                        <div class="btn-group">
                            <? if ($item->Status == 0) {
                                echo 'Товара нет в наличии';
                            } ?>

                            <? if ($item->Status != 0) : ?>
                                <? if (!isset($carts['products'][$item->Id])) {
                                    $text = '';
                                } else {
                                    $text = "в корзине " . $carts['products'][$item->Id]['Quanty'] . ' * ' . $item->Units;
                                } ?>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-danger"><?= $text ?> </p>
                                    </div>
                                    <div class="col-6">
                                        <?= Html::submitButton(' ', ['class' => 'toch-button toch-add-cart fas fa-shopping-cart fa-lg']) ?>
                                    </div>
                                </div>



                            <? endif ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                        <? Pjax::end(); ?>
                    </div>

                </div>

            </div>
            <!--аналоги наличие -->
            <div class="row mt-2">
                <div class="col-sm-12">
                    <h4 class="ml-5 mt-2">Аналоги из наличия</h4>
                    <hr>
                    <? if ($analogs != NULL) {
                        $l = count($analogs);
                    } else {
                        $l = 1;
                    }
                    ?>

                    <? if (empty($analogs) || $l == 1 || $analogs == NULL) : ?>
                        <p>Аналоги из наличия отсутствуют</p>
                    <? else : ?>

                        <? for ($i = 0; $i < count($analogs); $i++) : ?>
                            <? if ($analogs[$i]['Id'] != $item->Id) : ?>
                                <div class="card mb-3">
                                    <div class="row no-gutters product-grid ">
                                        <div class="col-md-3">
                                            <div class="product-image p-2">
                                                <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $analogs[$i]['Id'], 'class' => 'image']) ?>">
                                                    <?
                                                    $img = Yii::getAlias('@webroot') . '/img/' . $analogs[$i]['Img'];
                                                    if (is_file($img)) {
                                                        $url = Yii::getAlias('@web') . '/img/' . $analogs[$i]['Img'];
                                                    } else {
                                                        $url = Yii::getAlias('@web') . '/img/products/defult_prodact.jpg';
                                                    }  ?>
                                                    <?= Html::img($url, ['alt' => 'Product', 'class' => 'pic ', 'title' => $analogs[$i]['MetaTitle']]) ?>
                                                </a>

                                                <ul class="social">
                                                    <?
                                                    if (!($wishlist['products'][$analogs[$i]])) :
                                                    ?>

                                                        <li><a href="<?= yii\helpers\Url::to(['autoshop/list',  'wish' => 'add', 'id' => $analogs[$i]['Id']]) ?>" data-tip="Add to Wishlist"><i class="fa fa-lg fa-heart-o"></i></a></li>
                                                    <? else : ?>
                                                        <li><a href="<?= yii\helpers\Url::to(['autoshop/list', 'wish' => 'del', 'id' => $analogs[$i]['Id']]) ?>" data-tip="Del from Wishlist"><i class="fa fa-lg fa-heart"></i></a></li>
                                                    <? endif ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-4">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $analogs[$i]['Id']]) ?>"><?= $analogs[$i]['Name']  ?></a>
                                                </h5>
                                                <p class="card-text"><?=
                                                                        $analogs[$i]['MetaTitle']
                                                                        ?></p>


                                                <div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 mt-5">
                                            <p class="card-text ">в наличии</p>
                                        </div>
                                        <div class="col-md-2 mt-5">
                                            <div class="price "><?= $analogs[$i]['Price'] . ' ' . $current['Name'] ?></div>
                                        </div>
                                        <div class="col-md-3 mt-5">
                                            <? if ($analogs[$i]['Status'] == 10) : ?>
                                                <? $nal = 0;
                                                if (empty($carts['products'])) {
                                                    $nal = 0;
                                                } else {
                                                    foreach ($carts['products'] as $cart) {
                                                        if ($cart['Id'] == $analogs[$i]['Id']) {
                                                            $nal = 1;
                                                        }
                                                    }
                                                }

                                                ?>
                                                <? if ($nal == 0) : ?>
                                                    <a class="add-to-cart " href="<?= yii\helpers\Url::to([
                                                                                        'autoshop/search',
                                                                                        'addCart' => 'add', 'id' => $analogs[$i]['Id'],
                                                                                        'count' => $analogs[$i]['MinQunt']
                                                                                    ])
                                                                                    ?>">
                                                        <i class="fa fa-shopping-cart"></i> <span>Купить</span>
                                                    </a>
                                                <? else : ?>
                                                    <a class="add-to-cart" href="<?= yii\helpers\Url::to([
                                                                                        'autoshop/search',

                                                                                        'delCart' => 'del', 'id' => $analogs[$i]['Id']
                                                                                    ]) ?>">
                                                        <i class="fa fa-shopping-cart"></i> <span>Удалить</span>
                                                    </a>
                                                <? endif ?>
                                            <? endif ?>
                                        </div>

                                    </div>
                                </div>
                            <? endif ?>
                        <? endfor ?>

                        <div class="row ">
                            <!-- Start Pagination Area -->
                            <div class="pagination-area">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="pagination">
                                            <?= \yii\widgets\LinkPager::widget(['pagination' => $pages]) ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- End Pagination Area -->

                        </div>
                    <? endif ?>
                </div>
            </div>
            <!--аналоги под заказ -->

            <div class="row">
                <div class="col-sm-12">
                    <h4 class="ml-5 mt-2">Аналоги под заказ</h4>
                    <hr>
                    <? if (empty($zakaz_products)) : ?>
                        <p>Аналоги под заказ отсутствуют</p>
                    <? else : ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <? //print_r($zakaz_products) ?>
                                <? foreach ($zakaz_products as $zakazItem) : ?>

                                    <div class="row no-gutters product-grid mb-2">

                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-1">
                                            <hr>

                                            <? //= Html::img($zakazItem->Img, ['alt' => $zakazItem->Description, 'class' => 'pic ', 'title' => $zakazItem->Description]) 
                                            ?>
                                            <p class="card-text mt-4"><?= $zakazItem['Brand'] ?></p>

                                        </div>
                                        <div class="col-md-2 ">
                                            <hr>
                                            <a href="#" class="bloggood-ru-ssilka">
                                                <h5 class="card-title mt-4"><?= $zakazItem['ProductName'] ?></h5>
                                            </a>
                                            <?
                                            $url2 = Yii::getAlias($zakazItem['Img']);
                                            if (!empty($url2)) :
                                            ?>
                                                <div class="bloggood-ru-div"> <?= Html::img($url2, ['alt' => $zakazItem['ProductName'], 'class' => 'pic ', 'title' => $zakazItem['ProductName']]) ?></div>

                                            <? endif ?>
                                        </div>
                                        <div class="col-md-3">
                                            <hr>

                                            <p class="card-text mt-4"><?= $zakazItem['Description'] ?></p>

                                        </div>
                                        <div class="col-md-1 ">
                                            <hr>
                                            <p class="mt-4"><?= $zakazItem['TermsDelive'] ?></p>
                                        </div>
                                        <div class=" col-md-1 price">
                                            <hr>
                                            <p class="card-text  mt-4"><i><?= round($zakazItem['EntryPrice'] * (1 + $zakazItem['Markup'] / 100) * $kursItem, 0)  ?> <?= $current['Name'] ?></i></p>
                                        </div>
                                        <div class="col-md-3">
                                            <hr>

                                            <? if ($zakazItem['Count'] > 0) : ?>
                                                <? $nalZakaz = 0;
                                                if ($carts['zakaz'] == []) {
                                                    $nalZakaz = 0;
                                                } else {

                                                    foreach ($carts['zakaz'] as $cart) {
                                                        if ($cart['ProductName'] == $zakazItem['ProductName']) {
                                                            $nalZakaz = 1;
                                                        }
                                                    }
                                                }

                                                ?>
                                                <? if ($nalZakaz == 0) : ?>
                                                    <a class="add-to-cart mt-3" href="<?= yii\helpers\Url::to([
                                                                                            'autoshop/search',
                                                                                            'addZakaz' => 'add', 'id' => $zakazItem['Id']
                                                                                        ])
                                                                                        ?>">
                                                        <i class="fa fa-shopping-cart"></i> <span>Заказать</span>
                                                    </a>
                                                <? else : ?>
                                                    <a class="add-to-cart mt-3" href="<?= yii\helpers\Url::to([
                                                                                            'autoshop/search',

                                                                                            'delZakaz' => 'del', 'id' => $zakazItem['Id']
                                                                                        ]) ?>">
                                                        <i class="fa fa-shopping-cart"></i> <span>Отменить заказ</span>
                                                    </a>
                                                <? endif ?>

                                            <? endif ?>
                                        </div>
                                    </div>
                                <? endforeach ?>
                                <?= \yii\widgets\LinkPager::widget(['pagination' => $pagesZ]); /* постраничная навигация */ ?>
                            </div>
                        </div>
                    <? endif ?>
                </div>

            </div>

            <div class="row">
                <!--рекомендованный товар-->
                <div class="col-sm-12">
                    <h3 class="page-header text-center  p-5">С этим товаром покупают</h3>
                </div>
                <div class="owl-carouselRec card-group mr-5 mb-5 pr-5 owl-theme ">
                    <? if (empty($recItem))
                        echo 'Информация временно отсутсвует...';

                    ?>
                    <? foreach ($recItem as $rItem) : ?>

                        <div class="card text-center heightCard">
                            <a href=" <?= yii\helpers\Url::to(['autoshop/view', 'id' => $rItem->Id]) ?>">
                                <?= Html::img('@web/img/' . $rItem->Img, ['class' => 'card-img-top pic']) ?>
                            </a>
                            <div class="card-body overflow-hidden">
                                <h5 class="card-title"><?= $rItem->Name ?></h5>
                                <p class="card-text"><?= $rItem->MetaTitle ?></p>

                            </div>
                            <div class="card-footer"><?= $rItem->Price . ' ' . $current->Name ?></div>
                        </div>

                    <? endforeach ?>
                </div>

            </div>

        </div>

    </div>
    <!-- Start Toch-Box -->

    <!-- End Toch-Box -->
    <!-- START PRODUCT-AREA -->



</div>
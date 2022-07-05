<?php


use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Store;
use app\models\Current;
use app\models\Lang;
use app\models\Wishlist;
use app\models\Carts;
use app\models\Products;

$session = Yii::$app->session;
$session->open();
$customer = Yii::$app->session->get('customer');
$greeting = Yii::$app->session->get('greeting');
$currentCurr = Yii::$app->session->get('current');
$langCurr = Yii::$app->session->get('lang');
$idCustom = $customer['Id'];
//$lang = Yii::$app->session->get('lang');

if ($session->has('store')) {
    $store = $session->get('store');
} else {
    $store = Store::find()->select('Id, Name_shop,  Description, Meta_title, Meta_description, Meta_keyword, Phone, Viber,Facebook_link, Adress,Telegram_link, Logo, logo_small, Description_ua, Meta_title_ua, Meta_description_ua, Meta_keyword_ua, Work_time_ua, Info, Adress_ua')->where(['Id' => 1])->one();
    $session->set('store', [
        'Name_shop' => $store->Name_shop,
        'Meta_title' => $store->Meta_title,
        'Meta_description' => $store->Meta_description,
        'Meta_keyword' => $store->Meta_description,
        'Phone' => $store->Phone,
        'Viber' => $store->Viber,
        'Facebook_link' => $store->Facebook_link, 'Adress' => $store->Adress,
        'Telegram_link' => $store->Telegram_link,
        'Logo' => $store->Logo,
        'logo_small' => $store->logo_small, 'Description_ua' => $store->Description_ua,
        'Meta_title_ua' => $store->Meta_title_ua, 'Meta_description_ua' => $store->Meta_description_ua, 'Meta_keyword_ua' => $store->Meta_keyword_ua,
        'Work_time_ua' => $store->Work_time_ua,
        'Info' => $store->Info, 'Adress_ua' => $store->Adress_ua
    ]);
}
$currents = Current::find()->select('Id, Name, Small_name')->all();
$lang = Lang::find()->select('Id, language, Abb, Img')->all();

//$wishlist = Wishlist::find()->select('IdCustomer, IdProduct, DateAdd')->where(['IdCustomer' => $idCustom])->all();
if (!Yii::$app->session->has('wish_auto')) {
    Yii::$app->session->set('wish_auto', []);
    $countSES = 0;
} else {
    $wishlistSesion =  Yii::$app->session->get('wish_auto');
    $countSES = 0;
    if (isset($wishlistSesion['products'])) {
        foreach ($wishlistSesion['products'] as $ses) {
            $countSES = 1 + $countSES;
        }
    } else {
        $countSES = 0;
    }
}

// 
if (!Yii::$app->session->has('wish_auto')) {
    Yii::$app->session->set('wish_auto', []);
    $wishlist = [];
    $countwishlist = 0;
} else {
    $wishlist = Yii::$app->session->get('wish_auto');
    if (count($wishlist) == 0) {
        $countwishlist = 0;
    } else {
        $countwishlist = count($wishlist['products']);
    }
}
$ss = [];

if (!Yii::$app->session->has('cart')) {
    Yii::$app->session->set('cart', []);

    if (count($ss) == 0) {
        $textCart = 'порожній';
    }
} else {
    $ss = Yii::$app->session->get('cart');

    if (empty($ss['products']) && empty($ss['zakaz'])) {
        $textCart = 'порожній';
    } else {
        //   var_dump(count($ss['products']));
        if (!empty($ss['products'])) {
            $textCart = count($ss['products']);
        }
        if (!empty($ss['zakaz'])) {
            $textCart = $textCart + count($ss['zakaz']);
        }
        //+ count($ss['zakaz']);
    }
}

// function LangChange($lani)
// {
//     $l = [];
//     $session = Yii::$app->session;
//     $session->open();
//     $l = ['Id' => 1, 'language' => 'Русский', 'Abb' => 'ru'];
//     // ['Id' => $lani->Id, 'language' => $lani->language, 'Abb' => $lani->Abb];
//     //var_dump($l);
//     return $session->set('lang', $l);

//     //Yii::$app->getResponse()->redirect(Yii::$app->getRequest()->getUrl());
// }

?>

<div id="myrow">
    <div class="sp">
        <a href="<?= $store['Facebook_link'] ?>">
            <div class="sprites facebook"> </div>
        </a>
        <a href="viber://chat?number=%2B<?= $store['Viber'] ?>">
            <div class="sprites viber"> </div>
        </a>
        <a href="<?= yii\helpers\Url::to(['autoshop/contact']) ?>">
            <div class="sprites mail"></div>
        </a>
        <a href="<?= yii\helpers\Url::to(['autoshop/cart']) ?>" class="btn">
            <div class="conactItem "><i class="fas fa-shopping-cart fa-lg"></i></div>
        </a>

        <a onclick=" javascript:history.back();" class="btn " title="Назад">
            <div class="back btn-info pt-2"> <i class="fas fa-angle-double-left "></i></div>
        </a>



    </div>
</div>


<div class="container-fluid info-nav">
    <div class="row">
        <div class="top-menu col-sm-1">
            <!-- Start Language -->
            <div class="language" id="lag">

                <a class="lag" href="#">
                    <?= Html::img('@web/img/' . $lang[0]->Img, ['class' => 'flag-' . $lang[0]->Abb]) ?>&nbsp;
                </a>
            </div>
            <!-- End Language -->
            <!-- Start Currency -->
            <!--<ul class="currency"> -->

            <!-- <ul class="currency">
                <? foreach ($currents as $cur) : ?>
                <? if ($cur->Name == $currentCurr['Name']) : ?>
                <li> <a data-toggle="dropdown" class="dropdown-toggle active" href="#">
                        <?= $cur->Small_name . ' ' . $cur->Name ?>

                    </a>
                    <? endif
                    ?>
                    <? endforeach ?>
                    <ul>
                        <? foreach ($currents as $cur) : ?>
                        <li> <a href="#">
                                <?= $cur->Small_name . ' ' . $cur->Name ?>

                            </a></li>
                        <? endforeach ?>
                    </ul>


                </li>
            </ul> -->
            <!-- <select id="currency" name="currency" class="currency">
                            <? //foreach ($currents as $cur) : 
                            ?>
                                <? // if ($cur->Name == 'UAH') : 
                                ?>
                                    <option value="<? //= $cur->Name 
                                                    ?>  " selected="selected"><? //= $cur->Small_name . ' ' . $cur->Name 
                                                                                ?></option>
                                <? // else : 
                                ?>
                                    <option value="<? //= $cur->Name 
                                                    ?>"><? //= $cur->Small_name . ' ' . $cur->Name 
                                                        ?></option>
                                <? // endif 
                                ?>
                            <? // endforeach 
                            ?>
                        </select> -->
            <!-- End Currency -->

        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-3 pl-0 pr-0">
                    <p class="text-light text-left mt-2 "><?= $greeting ?>,
                        <?= $customer['FName'] ?>
                    </p>
                </div>
                <div class="col-sm-9">
                    <p id="adr" class="text-light  mt-2"><?= $store['Adress_ua'] ?> ☎ <?= $store['Phone'] ?> </p>
                </div>
            </div>

        </div>
        <div class="col-sm-2 mt-2">
            <!-- <nav class="nav"> -->
            <a href="<?= yii\helpers\Url::to(['autoshop/contact']) ?>" class="ml-1 text-light" title="Контакти">☎</a>

            <?
            if ($customer['Id'] == 1) {
                $accountMSG = 'Вхід до кабінету';
                $accountUrl = yii\helpers\Url::to(['autoshop/login']);
                //  $logout='';
            } else {
                $accountMSG = 'Мій кабінет';
                $accountUrl = yii\helpers\Url::to(['autoshop/account']);
                //$logout =yii\helpers\Url::to(['autoshop/exit']); 
                // $logoutText ='Выход';
            }

            ?>
            <a href="<?= $accountUrl ?>" title="<?= $accountMSG ?>" class="ml-1 mr-1 text-light"><i class="fa fa-sign-in "></i></a>

            <a href="<?= yii\helpers\Url::to(['autoshop/wishlist']) ?>" class=" text-danger" title="Список бажань"><i class="fa fa-lg fa-heart text-danger">(<?= $countwishlist ?>) </i> </a>
            <!-- <a href="<? // = $logout 
                            ?>" class="nav-link" title="Выход"><i class="fas fa-lg fa-share"></i> </a> -->
            <!-- </nav> -->
        </div>
    </div>
</div>
<div class="row runRow">
    <marquee scrollamount="4" style="color: #ffffff; font-size: 24px; font-weight: bolder; line-height: 150%; text-shadow: #000ff0 0px 1px 1px;" class=" mt-0"> <?= ' ' . $store['Meta_description_ua'] . ' *  * ' . $store['Meta_description_ua'] ?></marquee>
</div>
<header class="container-fluid my-header flex-column">

    <!-- <div id="snow"> -->
    <div class="container hd_box">


        <div class="row">
            <div class="col-sm-4">
                <div id="logo" class="col">

                    <?= Html::img('@web/img/' . $store['Logo'], ['class' => 'logo']) ?>
                    <!-- <div class="logo"> -->
                    <div class="text_logo">
                        <a href="<?= Url::home() ?>">
                            <?= $store['Name_shop'] ?>
                            <!-- Avtograd.net.ua -->
                        </a>
                    </div>
                    <!-- </div> -->
                </div>
            </div>
            <div class="col-sm-8" id="media-button">
                <div class="button ml-2 " id="cartHeader">

                    <input type="submit" value="Кошик (<?= $textCart ?>)" data-toggle="modal" data-target="#exampleModal" />

                </div>


            </div>

        </div>

        <!--  </div> -->
        <div class="row">
            <div class="col-sm-7 offset-sm-5" id="mobileSearch">
                <? //= Html::img('@web/img/' . $store->Logo, ['class' => 'small']) 
                ?>
                <form class="form-inline my-2 my-lg-0 " id="searchForm" method="get" action="<?= Url::to(['autoshop/search']); ?>">
                    <div class="button">
                        <input class="form-control mr-sm-2" type="search" name="query" placeholder="Пошук" aria-label="Search">
                        <button class="btn btn-outline-success ml-1 my-sm-0" type="submit">&#8680;</button>

                    </div>
                </form>
            </div>

        </div>

    </div>
    <div class="row " id="runInfo">
        <div class="container">

            <div class="col-sm-12 ">
                <i class="text-center ml-5"> <?= $store['Info'] ?></i>
            </div>

        </div>


        <!-- <marquee direction="right" style="color: #ffffff; font-size: 16px; font-weight: bolder; text-shadow: #000000 0px 1px 1px;"> -->

        <!-- </marquee> -->
    </div>

</header>
<?php

use yii\helpers\Url;
use app\models\Store;


$session = Yii::$app->session;
$session->open();
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
//var_dump($store);
?>

<footer>
    <div class="container">
        <div class="row myrow">
            <div class="col-sm-3">
                <h5>Інформація</h5>

                <ul class="list-unstyled">
                    <? foreach ($this->context->pageMenu as $page) : ?>

                        <? if ($page['parent_id'] == 1) : ?>
                            <li><a href="<?= yii\helpers\Url::to(['autoshop/page', 'slug' => $page['Slug']]) ?>"><?= $page['Name_ua'] ?></a></li>
                        <? endif ?>
                    <? endforeach ?>

                </ul>

            </div>
            <div class="col-sm-3">
                <h5>Служба підтримки </h5>
                <ul class="list-unstyled">
                    <li> <a href="<?= yii\helpers\Url::to(['autoshop/contact']) ?>">Контакти</a></li>
                    <? foreach ($this->context->pageMenu as $page) : ?>

                        <? if ($page['parent_id'] == 5) : ?>
                            <li><a href="<?= yii\helpers\Url::to(['autoshop/page', 'slug' => $page['Slug']]) ?>"><?= $page['Name_ua'] ?></a></li>
                        <? endif ?>
                    <? endforeach ?>

                </ul>

            </div>
            <div class="col-sm-3">
                <h5>Додатково</h5>
                <ul class="list-unstyled">

                    <li><a href="<?= yii\helpers\Url::to(['autoshop/actia']) ?>">Акції</a></li>

                    <? foreach ($this->context->pageMenu as $page) : ?>

                        <? if ($page['parent_id'] == 9) : ?>
                            <li><a href="<?= yii\helpers\Url::to(['autoshop/page', 'slug' => $page['Slug']]) ?>"><?= $page['Name_ua'] ?></a></li>
                        <? endif ?>
                    <? endforeach ?>
                </ul>

            </div>
            <div class="col-sm-3">
                <?
                //  var_dump($store);
                ?>
                <h5>Ми завжди на зв'язку</h5>
                <h6>Контактні телефони</h6>
                <h6>+38(066)7906540</h6>
                <h6>+38(063)7612590</h6>
                <div class="sp">
                    <a href="<?= $store['Facebook_link'] ?>                   
                    ">
                        <div class="sprites facebook"> </div>
                    </a>
                    <a href="viber://chat?number=%2B<?= $store['Viber'] ?>">
                        <div class="sprites viber"> </div>
                    </a>
                    <a href="<?= yii\helpers\Url::to(['autoshop/contactform']) ?>">
                        <div class="sprites mail">

                        </div>
                    </a>
                </div>
            </div>
        </div>
        <hr id="row-up">

        <center>&copy; Shishkova - <?php echo date('Y'); ?></center>
    </div>
</footer>
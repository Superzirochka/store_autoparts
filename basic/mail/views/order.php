<?php

//use Yii;
use app\models\Store;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\ZakazProducts;

$session = Yii::$app->session;
$session->open();
$store = $session->get('store');
// Store::find()->select(' Id, Name_shop,  Description, Meta_title, Meta_description, Meta_keyword, Phone, Viber,Facebook_link , Work_time, Email, Adress,Owner, Telegram_link, Google_map, Logo, Logo_small, Id_lang, Description_ua, Meta_title_ua, Meta_description_ua, Meta_keyword_ua, Work_time_ua, Adress_ua')->where(['Id_lang' => $langCurr['Id']])->one();

$this->title = 'Заказ  № ' . $person['numorder'] . ' от Avtograd.net.ua';
?>

<div class="row">
    <h4>Здравствуйте вы совершили покупку в нашем интернет- магазине автозапчастей
    </h4>
    <div class="col-sm-4">
        <div>
            <img src="https://avtograd.net.ua/img/logo-1611944919.png" alt=""> <!-- <div class="logo"> -->
            <div>
                <a href="https://avtograd.net.ua">
                    Avtograd.net.ua
                    <!-- Avtograd.net.ua -->
                </a>
            </div>
            <!-- </div> -->
        </div>
    </div>
    <!-- <h3><a href="https://avtograd.net.ua/">
            Avtograd.net.ua
        </a> </h3> -->
    <h4>Информация о заказа</h4>

    <h1><?= Html::encode($this->title); ?></h1>

    <ul>
        <li>Покупатель: <?= Html::encode($person['name']); ?> <?= Html::encode($person['lastname']); ?></li>
        <li>E-mail: <?= Html::encode($person['email']); ?></li>
        <li>Телефон: <?= Html::encode($person['phone']); ?></li>
    </ul>

</div>

<div class="row">
    <table border="1" cellpadding="3" cellspacing="0" class="col-sm-12">
        <tr>
            <th align="left">Наименование</th>
            <th align="left">Наличие</th>
            <th align="left">Кол-во, шт</th>
            <th align="left">Цена, грн.</th>
            <th align="left">Сумма, грн.</th>
        </tr>
        <? if (!empty($order['products'])) : ?>
            <tr>
                <td colspan="5">Товар в наявності</td>
            </tr>
            <?php foreach ($order['products'] as $product) : ?>
                <tr>
                    <td align="left"><?= Html::encode($product['Name']); ?></td>
                    <td align="left">в наличии</td>
                    <td align="right"><?= $product['Quanty']; ?></td>
                    <td align="right"><?= $product['Price']; ?></td>
                    <td align="right"><?= $product['Quanty'] * $product['Price']; ?></td>
                </tr>
            <?php endforeach; ?>
        <? endif ?>
        <? if (!empty($order['zakaz'])) : ?>
            <tr>
                <td colspan="5">Товар під замовлення</td>
            </tr>
            <?php foreach ($order['zakaz'] as $zakaz) : ?>
                <? $z = ZakazProducts::findOne($zakaz['Id']); ?>
                <tr>
                    <td align="left"><?= Html::encode($zakaz['ProductName']); ?></td>
                    <td align="left"><?= $z->TermsDelive ?></td>
                    <td align="right"><?= $zakaz['Quanty']; ?></td>
                    <td align="right"><?= $zakaz['Price']; ?></td>
                    <td align="right"><?= $zakaz['Quanty'] * $zakaz['Price']; ?></td>
                </tr>
            <?php endforeach; ?>
        <? endif ?>
        <tr>
            <td colspan="3" align="right">Итого</td>
            <td align="right"><?= $order['amount']; ?></td>
        </tr>
        <tr>
            <td colspan="2">
                Адрес доставки:
            </td>
            <td>
                <?= $person['dostavka'] ?>
            </td>
            <td>
                <?= Html::encode($person['adress']); ?>
            </td>
        </tr>
        <?
        if ($person['note'] == null) {
            $note = 'Комментарий отсутствует';
        } else {
            $note = $person['note'];
        }
        ?>
        <tr>
            <td>
                <p>Комментарий: </p>
            </td>
            <td colspan="3">
                <?= $note ?>
            </td>
        </tr>
    </table>


</div>
<?php
$session = Yii::$app->session;
/* @var $this \yii\web\View */
/* @var $content string */


use app\widgets\Alert;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Products;
use app\models\Store;
use app\models\ZakazProducts;

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


AppAsset::register($this); //регистрируем 

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php $this->registerCsrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
  <link rel="shortcut icon" type="image/png" sizes="15x50" href="img/<?= $store['logo_small'] ?>
">
</head>

<body id="greyMy">

  <!-- modal window -->

  <!-- start header--->



  <?= $this->render('_header') ?>

  <!-- stop header--->
  <?php //echo $store['Logo_small'] 
  ?>
  <!-- start menu--->
  <a onclick=" javascript:history.back();" class="btn " title="Назад">
    <div class="backB pt-2"> <i class="fas fa-angle-double-left mt-2"></i></div>
  </a>
  <?= $this->render('_menu') ?>
  <!-- stop menu--->

  <!--контент start-->


  <!-- <div class="page-content"> -->

  <div class="container">
    <?php if (Yii::$app->session->hasFlash('warning') || Yii::$app->session->hasFlash('success')) : ?>
      <div class=" alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
          <span aria-hidden="true">&times;</span>
        </button>
        <p>

          <?= Yii::$app->session->getFlash('success'); ?>
        </p>
        <p><?= Yii::$app->session->getFlash('warning'); ?></p>
      </div>
    <?php endif; ?>
    <div class="row shadow-none p-1 bg-white ">

      <nav aria-label="breadcrumb" class="col-md-12 bg-white  mt-1 mb-1 ">
        <?= yii\widgets\Breadcrumbs::widget([

          'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <? //$this->params['breadcrumbs'][] = Yii::$app->controller->substr_content($this->title, '90'); ?>

      </nav>
    </div>
  </div>
  <div class="row">

    <?= $content ?>

  </div>
  </div>

  <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Ваша корзинa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <? $session = Yii::$app->session;
        $session->open();
        if (!$session->has('cart')) {
          $session->set('cart', []);
          $cart = [];
        } else {
          $cart = $session->get('cart');
        }

        if (count($cart) == 0 || empty($cart['products']) && empty($cart['zakaz']) ): ?>
        <div class="modal-body ">
          <p>Ваша корзина пуста</p>
        </div>
        <? else : ?>
        <div class="modal-body ">
          <table class="table table-hover">
            <tbody>
              <?if (!empty($cart['products'])): ?>
              <tr>
                <td scope="col" colspan="5">из наличия</td>

              </tr>

              <? foreach ($cart['products'] as $cItem) : ?>

              <?
                  $prodItem = Products::findOne($cItem['Id']);
                  // if ($prodItem->Id == $cItem['Id']) : 
                 
              if (!empty($prodItem->Img)) {
                  $img = Yii::getAlias('@webroot') . '/img/' . $prodItem->Img;
                  if (is_file($img)) {
                      $url = Yii::getAlias('@web') . '/img/' .$prodItem->Img;             
                  }
              }else{
                  $url= Yii::getAlias('@web') . '/img/products/defult_prodact.jpg';
              }
                ?>
              <tr>
                <td>
                  <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $prodItem->Id]) ?>">
                    <?= Html::img($url, ['alt' => 'Product', 'class' => 'picG ml-3']) ?>
                  </a>
                </td>
                <td class="align-middle">
                  <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $prodItem->Id]) ?>">
                    <h4><?= $prodItem->Name ?></h4>
                  </a>
                </td>
                <td class="align-middle">
                  <strong class="p-2 bd-highlight"><?= $cItem['Quanty'] ?> * </strong>
                  <strong class="p-2 bd-highlight"><?= $prodItem->Price ?></strong>
                </td>
                <td class="text-right align-middle">
                  <a class="btn btn-danger" href="<?= yii\helpers\Url::to([
                                                    'autoshop/list',
                                                    // 'idCat' => $item->Id_category, 'nameCategory' =>  $catName, 
                                                    'delCart' => 'del', 'id' => $prodItem->Id
                                                  ]) ?>">
                    <i class="fa fa-times"></i>
                  </a>
                  <!-- <a href="<?= yii\helpers\Url::to(['autoshop/cart', 'id' => $prodItem->Id, 'del' => 'delete']) ?>" class="btn btn-danger" data-toggle="tooltip" title="" data-original-title="Remove"> -->

                  <!-- <i class="fa fa-times"></i>
                  </a> -->
                </td>
              </tr>

              <? endforeach ?>
              <?endif?>
              <?if (!empty($cart['zakaz'])):?>
              <tr>
                <td scope="col" colspan="5">заказные</td>

              </tr>

              <?foreach ($cart['zakaz'] as $itemZakaz):?>
              <tr>

                <?
              $prodZakaz = ZakazProducts::findOne($itemZakaz['Id']);
              ?>
                <td>
                  <?
                   $url1= Yii::getAlias($prodZakaz->Img);
                   
                  ?>
                  <?= Html::img($url1, ['alt' => 'Product', 'class' => 'picG ml-3']) ?>



                </td>
                <td class="align-middle">

                  <h4><?= $itemZakaz['ProductName'] ?></h4>

                </td>
                <td class="align-middle">
                  <strong class="p-2 bd-highlight"><?= $itemZakaz['Quanty'] ?> * </strong>
                  <strong class="p-2 bd-highlight"><?= $itemZakaz['Price'] ?></strong>
                </td>
                <td class="text-right align-middle">
                  <a class="btn btn-danger" href="<?= yii\helpers\Url::to([
                                                    'autoshop/search',
                                                    // 'idCat' => $item->Id_category, 'nameCategory' =>  $catName, 
                                                    'delZakaz' => 'del', 'id' => $itemZakaz['Id']
                                                  ]) ?>">
                    <i class="fa fa-times"></i>
                  </a>

                </td>
              </tr>
              <?endforeach?>
              <?endif?>
            </tbody>
            <tfoot>
              <tr>
                <td scope="col" colspan="2" class="pt-5" style="text-align:right"><strong>
                    ИТОГО:</strong></td>
                <td style="text-align:right" scope="col" class="pt-5"><strong> <span><?= $cart['amount'] ?><?= $sumCart ?> грн</span></strong></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <? endif ?>
        <div class="modal-footer">
          <a href="<?= yii\helpers\Url::to(['autoshop/cart']) ?>" class="btn btn-secondary">Перейти в корзину</a>
          <a href="<?= Url::to(['autoshop/cart', 'clear' => 'yes']); ?>" class="btn btn-danger" onclick="<?= Url::remember(); ?>">
            Очистить корзину
          </a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!--контент end-->
  <!-- start footer--->
  <?= $this->render('_footer') ?>
  <!-- stop footer--->
  <?php $this->endBody() ?>

</body>


</html>
<?php $this->endPage() ?>
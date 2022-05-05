<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Category;
use app\models\Wishlist;
use app\models\Carts;
use app\models\Reviews;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\ZakazProducts;

$cat =  Category::find()->select('Id, Id_lang
, Name, Description,  MetaTitle, MetaDescription, MetaKeyword,  Id_parentCategory, Img')->all();

$this->title = $nameCategory;

$this->registerMetaTag(
    ['name' => 'ShopName', 'content' =>  Yii::$app->params['shopName']]
);
$this->registerMetaTag(
    ['name' => 'keywords', 'content' => $nameCategory . ',' . Yii::$app->params['defaultKeywords']]
);
$this->registerMetaTag(
    ['name' => 'description', 'content' => $nameCategory . ', ' . Yii::$app->params['defaultDescription']]
);
$this->params['breadcrumbs'][] = $this->title;
$today = date("Y-m-d");

$session = Yii::$app->session;
$session->open();
if (!$session->has('cart')) {
    $session->set('cart', []);
    $carts = [];
} else {
    $carts = $session->get('cart');
}
$kursItem = $kurs->Current_kurs;

?>



<div class="container my-shadow " id="content_box">

    <div class="row">

        <div class="col-sm-3">
            <?= app\components\CategoryWidget::widget(); ?>
            <!-- <?= app\components\BrandWidget::widget() ?> -->
        </div>
        <!-- товар-->
        <div class="col-sm-9">

            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-header text-center"><?= $nameCategory  ?>

                    </h3>
                    <?if (!empty($cat)):?>
                    <? foreach ($cat as $c) : ?>
                    <ul class="list-group">
                        <? if ($c->Id_parentCategory == $idCat & $c->Id_parentCategory != 0) : ?>
                        <li class="list-group-item mycolor"><a href=" <?= yii\helpers\Url::to(['autoshop/list', 'idCat' => $c->Id, 'nameCategory' =>  $c->Name]) ?>" class='mycolor'><?= $c->Name ?></a></li>
                        <? endif ?>
                    </ul>
                    <? endforeach ?>
                    <?endif?>
                </div>
            </div>
            <? if (count($prods) == 0) : ?>
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center m-3">В данной категории пока нет товара</h3>
                </div>
            </div>
            <?endif?>
            <!-- сортировка -->
            <div class="row mt-2">
                <?
                        if (!empty($prods)): ?>
                <div class="col-sm-12 d-flex justify-content-end mr-3">
                    <?
                            $sort = [
                                ['id'=>1, 'name'=>'По умолчению'],
                                ['id'=>2, 'name'=> 'От дорогих к дешевым'],
                                ['id'=>3, 'name'=> 'От дешевых к дорогим'],
                                ['id'=>4, 'name'=> 'Названию'],
                            ];
                       
                                ?>

                    <ul class="list-inline">
                        <li class="list-inline-item">
                            Сортировка:
                        </li>
                        <? foreach ($sort as $sortItem):?>
                        <li class="list-inline-item"><a href="<?= yii\helpers\Url::to(['autoshop/list', 'idCat' => $idCat, 'nameCategory' =>  $nameCategory, 'sort' => $sortItem['id']]) ?>" class="badge myBackgra">
                                <?= $sortItem['name'] ?>
                            </a></li>
                        <?endforeach?>
                    </ul>

                </div>
                <?endif?>
            </div>
            <!-- список товара -->
            <div class="row">
                <div class="col-sm-12">
                    <? foreach ($prods as $product) : ?>
                    <?
                                for($i=0; $i< count($cat); $i++){
                                    if($cat[$i]->Id == $product->Id_category){
                                         $catName = $cat[$i]->Name;
                                         }
                                    }?>
                    <div class="card mb-3">
                        <div class="row no-gutters product-grid ">
                            <div class="col-md-3">
                                <div class="product-image p-2">
                                    <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $product['Id'], 'class' => 'image']) ?>">
                                        <?                                         
                                        $img = Yii::getAlias('@webroot') . '/img/' . $product['Img'];;
                                        if (is_file($img)) {
                                            $url = Yii::getAlias('@web') . '/img/' . $product['Img'];
                                            
                                        }else{
                                            $url= Yii::getAlias('@web') . '/img/products/defult_prodact.jpg';
                                        }  ?>
                                        <?= Html::img($url, ['alt' => 'Product', 'class' => 'pic ', 'title' => $product['MetaTitle']]) ?>
                                    </a>

                                    <ul class="social">
                                        <? 
                                            if (!($wishlist['products'][$product['Id']])):
                                        ?>

                                        <li><a href="<?= yii\helpers\Url::to(['autoshop/list',  'wish' => 'add', 'id' => $product['Id']]) ?>" data-tip="Add to Wishlist"><i class="fa fa-lg fa-heart-o"></i></a></li>
                                        <? else : ?>
                                        <li><a href="<?= yii\helpers\Url::to(['autoshop/list', 'wish' => 'del', 'id' => $product['Id']]) ?>" data-tip="Del from Wishlist"><i class="fa fa-lg fa-heart"></i></a></li>
                                        <? endif ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3 mt-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $product['Id']]) ?>"><?= $product['Name']  ?></a>
                                    </h5>
                                    <p class="card-text"><?=
                                                            $product['MetaTitle']
                                                            ?></p>


                                    <div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 mt-5">
                                <p class="card-text ">в наличии</p>
                            </div>
                            <div class="col-md-2 mt-5">
                                <div class="price "><?= $product['Price'] . ' ' . $current['Name'] ?></div>
                            </div>
                            <div class="col-md-3 mt-5">
                                <?if( $product['Status']== 10):?>
                                <? $nal = 0;
                                            if ($carts == []) {
                                                $nal = 0;
                                            } else {
                                                if (!empty($carts['products'])){
                                                    foreach ($carts['products'] as $cart) {
                                                        if ($cart['Id'] == $product['Id']) {
                                                            $nal = 1;
                                                        }
                                                    }
                                                }    
                                            }
                                           
                                            ?>
                                <? if ($nal == 0) : ?>
                                <a class="add-to-cart " href="<?= yii\helpers\Url::to([
                                                                    'autoshop/search',
                                                                    'addCart' => 'add', 'id' => $product['Id'],
                                                                    'count' => $product['MinQunt']
                                                                ])
                                                                ?>">
                                    <i class="fa fa-shopping-cart"></i> <span>Купить</span>
                                </a>
                                <? else : ?>
                                <a class="add-to-cart" href="<?= yii\helpers\Url::to([
                                                                    'autoshop/search',

                                                                    'delCart' => 'del', 'id' => $product['Id']
                                                                ]) ?>">
                                    <i class="fa fa-shopping-cart"></i> <span>Удалить</span>
                                </a>
                                <? endif ?>
                                <? endif ?>
                            </div>

                        </div>
                        <?
                                $analogs=explode(',', $product['Tegs']);
                                
                                $zakazItems=[];
                              
                                // array_push($analogs, $product['Name']);
                             
                             foreach($analogs as $analog){
                                    if(!empty($analog)){
                                       
                                   $zakaz =ZakazProducts::find()
                                //    -> select('Id', 'Brand', 'ProductName', 'Description', 'Img', 'Price', 'TermsDelive')
                                   ->where(['ProductName'=>trim($analog), ])->all();
                                 
                                  if (!empty($zakaz))
                                   {
                                        foreach($zakaz as $an)
                                        {    //print_r($an);
                                            array_push($zakazItems, $an);
                                        }
                                    }
                                }
                             }
                          
                               
                                foreach($zakazItems as $zakazItem):
                                ?>
                        <!-- item for zakaz -->
                        <div class="row no-gutters product-grid mb-2">

                            <div class="col-md-1">
                            </div>

                            <div class="col-md-1">
                                <hr>

                                <?//= Html::img($zakazItem->Img, ['alt' => $zakazItem->Description, 'class' => 'pic ', 'title' => $zakazItem->Description]) ?>
                                <p class="card-text mt-4"><?= $zakazItem->Brand ?></p>

                            </div>
                            <div class="col-md-2">
                                <hr>
                                <a href="#" class="bloggood-ru-ssilka">
                                    <h5 class="card-title mt-4"><?= $zakazItem->ProductName ?></h5>
                                </a>
                                <?
                                            $url1= Yii::getAlias($zakazItem->Img);
                                            if(!empty($url1)):
                                            ?>
                                <div class="bloggood-ru-div"> <?= Html::img($url1, ['alt' => 'Product', 'class' => 'pic ', 'title' => $zakazItem->ProductName]) ?></div>

                                <?endif?>
                            </div>
                            <div class="col-md-3">
                                <hr>

                                <p class="card-text mt-4"><?= $zakazItem->Description ?></p>

                            </div>
                            <div class="col-md-1 ">
                                <hr>
                                <p class="mt-4"><?= $zakazItem->TermsDelive ?></p>
                            </div>
                            <div class=" col-md-1 price">
                                <hr>
                                <p class="card-text  mt-4"><i><?= round($zakazItem->EntryPrice * (1 + $zakazItem->Markup / 100) * $kursItem, 0)  ?> <?= $current['Name'] ?></i></p>
                            </div>
                            <div class="col-md-3">
                                <hr>

                                <?if( $zakazItem->Count > 0):?>
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
                                                                        'addZakaz' => 'add', 'id' => $zakazItem->Id
                                                                    ])
                                                                    ?>">
                                    <i class="fa fa-shopping-cart"></i> <span>Заказать</span>
                                </a>
                                <? else : ?>
                                <a class="add-to-cart mt-3" href="<?= yii\helpers\Url::to([
                                                                        'autoshop/search',

                                                                        'delZakaz' => 'del', 'id' => $zakazItem->Id
                                                                    ]) ?>">
                                    <i class="fa fa-shopping-cart"></i> <span>Отменить заказ</span>
                                </a>
                                <? endif ?>
                                <? endif ?>
                            </div>
                        </div>
                        <?endforeach?>

                    </div>

                    <?endforeach?>
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


                </div>
            </div>
            <!--рекомендованный товар-->
            <div class="row">



                <?= app\components\Recomendprod::widget() ?>


            </div>




        </div>

    </div>
</div>
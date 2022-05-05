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
                    <? foreach ($cat as $c) : ?>
                    <ul class="list-group">
                        <? if ($c->Id_parentCategory == $idCat & $c->Id_parentCategory != 0) : ?>
                        <li class="list-group-item mycolor"><a href=" <?= yii\helpers\Url::to(['autoshop/list', 'idCat' => $c->Id, 'nameCategory' =>  $c->Name]) ?>" class='mycolor'><?= $c->Name ?></a></li>
                        <? endif ?>
                    </ul>
                    <? endforeach ?>




                    <div class="row">
                        <div class="col-sm-12">
                            <? if (count($prods) == 0) : ?>
                            <h3 class="text-center m-3">В данной категории пока нет товара</h3>
                            <? endif ?>
                        </div>

                    </div>
                    <?
                    //var_dump($query->prepare(\Yii::$app->db->queryBuilder)->createCommand()->rawSql)
                    ?>

                    <div class="row productList">
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

                        <? foreach ($prods as $item) : ?>
                        <div class="col-md-4  col-sm-6 ">
                            <?
                                for($i=0; $i< count($cat); $i++){
                                    if($cat[$i]->Id == $item->Id_category){
                                         $catName = $cat[$i]->Name;
                                         }
                                    }
                                    ?>
                            <div class="product-grid ">
                                <div class="product-image">
                                    <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $item->Id, 'class' => 'image']) ?>">
                                        <?                                         
                                        $img = Yii::getAlias('@webroot') . '/img/' . $item->Img;
                                        if (is_file($img)) {
                                            $url = Yii::getAlias('@web') . '/img/' .$item->Img;
                                            
                                        }else{
                                            $url= Yii::getAlias('@web') . '/img/products/defult_prodact.jpg';
                                        }
                                    
                                        // $url= Yii::getAlias('@web') . 'img/products/defult_prodact.jpg';
                                    
                                    
                                    ?>

                                        <?= Html::img($url, ['alt' => 'Product', 'class' => 'pic ', 'title' => $item->MetaTitle]) ?>
                                    </a>

                                    <ul class="social">
                                        <? 
                                            if (!($wishlist['products'][$item->Id])):
                                        ?>

                                        <li><a href="<?= yii\helpers\Url::to(['autoshop/list',  'wish' => 'add', 'id' => $item->Id]) ?>" data-tip="Add to Wishlist"><i class="fa fa-lg fa-heart-o"></i></a></li>
                                        <? else : ?>
                                        <li><a href="<?= yii\helpers\Url::to(['autoshop/list', 'wish' => 'del', 'id' => $item->Id]) ?>" data-tip="Del from Wishlist"><i class="fa fa-lg fa-heart"></i></a></li>
                                        <? endif ?>
                                    </ul>
                                </div>
                                <div class="product-content">
                                    <h3 class="title overflow-hidden"><a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $item->Id]) ?>"><?= $item->Name
                                                                                                                                                    // . ' ' . $item->MetaTitle 
                                                                                                                                                    ?></a></h3>
                                    <div class="price"><?= $item->Price ?> <?= $current['Name'] ?> <?= $current->Small_name ?></div>

                                    <div>
                                        <? $nal = 0;
                                            if ($carts == []) {
                                                $nal = 0;
                                            } else {
                                                foreach ($carts['products'] as $cart) {
                                                    if ($cart['Id'] == $item->Id) {
                                                        $nal = 1;
                                                    }
                                                }
                                            }
                                           
                                            ?>
                                        <? if ($nal == 0) : ?>
                                        <a class="add-to-cart" href="<?= yii\helpers\Url::to([
                                                                            'autoshop/list',
                                                                            'addCart' => 'add', 'id' => $item->Id,
                                                                            'count' => $item->MinQunt
                                                                        ])
                                                                        ?>">
                                            <i class="fa fa-shopping-cart"></i> <span>Купить</span>
                                        </a>
                                        <? else : ?>
                                        <a class="add-to-cart" href="<?= yii\helpers\Url::to([
                                                                            'autoshop/list',
                                                                            // 'idCat' => $item->Id_category, 'nameCategory' =>  $catName, 
                                                                            'delCart' => 'del', 'id' => $item->Id
                                                                        ]) ?>">
                                            <i class="fa fa-shopping-cart"></i> <span>Удалить</span>
                                        </a>
                                        <? endif ?>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <? endforeach ?>
                    </div>



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
            <div class="row">

                <!--рекомендованный товар-->

                <?= app\components\Recomendprod::widget() ?>


            </div>

        </div>
    </div>
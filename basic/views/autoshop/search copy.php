<?php
/*
 * Страница результатов поиска по каталогу, файл views/catalog/search.php
 */

use app\models\ManufacturerAuto;
use app\models\ModelAuto;
use app\models\Modification;
use app\components\TreeWidget;
use app\components\BrandsWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\Wishlist;
use app\models\Carts;
use app\models\Reviews;
use app\models\Category;
use app\models\Engine;
use app\models\ValueEngine;
use app\models\NodeAuto;


$this->title = 'Результаты поиска по каталогу ' . $modelsSes->FullName;

?>


<div class="container my-shadow " id="content_box">

    <div class="row">

        <div class="col-sm-3 oemSearch">
            <? if (!empty($nodes)):?>


            <div class="row mt-1 mb-2">
                <div class="accordion col-sm-12" id="accordionAuto">
                    <?foreach($nodes as $node):?>
                    <?if ($node->Id_parentNode == NULL):?>
                    <div class="card">
                        <div class="card-header" id="heading<?= $node->Id ?>">
                            <h5 class="mb-0">
                                <button class="btn btn-link w-100" type="button" data-toggle="collapse" data-target="#collapse<?= $node->Id ?>" aria-expanded="false" aria-controls="collapse<?= $node->Id ?>">
                                    <div class="row">
                                        <div class="col-sm-6"><?= Html::img('/img/node/' . $node->Img, ['alt' => $node->Node, 'width' => '120px', 'height' => '50px', 'class' => 'lazy loaded']) ?></div>
                                        <div class="col-sm-6 mt-3">

                                            <?= $node->Node . '  ' ?>
                                            <span class="fa fa-chevron-right "> </span>
                                        </div>
                                    </div>
                                </button>
                            </h5>
                        </div>

                        <div id="collapse<?= $node->Id ?>" class="collapse" aria-labelledby="heading<?= $node->Id ?>" data-parent="#accordionAuto">
                            <div class="card-body">
                                <?$oemCodeChild='';
                $childs= NodeAuto::getAllChildIds($node->Id);
            //  echo($childs[0]);
            if(empty($childs)){
                foreach($oem as $i){
                    if($i->IdNode == $node->Id)
                   
                    $oemCodeChild.=$i->OEM.',';
                }                        
            }
                foreach($childs as $c){
                    foreach($oem as $i){
                        if($i->IdNode == $c)
                     //   print_r($i->IdNode);
                        $oemCodeChild.=$i->OEM.',';
                    }
                }
                
              // var_dump($childs);
                ?>
                                <?if (empty($childs)):?>
                                <a href="<?= yii\helpers\Url::to([
                                                'search',
                                                //'autoshop/search',
                                                'search' => $oemCodeChild
                                            ]) ?>">
                                    <?= $node->Node . '  ' ?>
                                </a>
                                <?else:?>

                                <a href="<?= yii\helpers\Url::to([
                                                'search',
                                                //'autoshop/search',
                                                'search' => $oemCodeChild
                                            ]) ?>">
                                    <?= $node->Node . '  ' ?>
                                </a>
                                <ul>
                                    <?foreach($childs as $child):?>

                                    <li>

                                        <?$c = NodeAuto::findOne($child);
                      $chis= NodeAuto::getAllChildIds($c->Id);
                    $oemCode='';
                    foreach($oem as $i){
                        if ($i->IdNode == $child){
                            $oemCode.=$i->OEM.','; 
                        }
                    }
                    ?>
                                        <a href="<?= yii\helpers\Url::to([
                                                        'search',
                                                        //'autoshop/search',
                                                        'search' => $oemCode
                                                    ]) ?>">
                                            <?= $c->Node ?>
                                        </a>


                                    </li>
                                    <?endforeach?>
                                </ul>
                                <?endif?>
                            </div>
                        </div>
                    </div>
                    <?endif?>
                    <?endforeach?>

                </div>
            </div>

            <?endif?>
        </div>

        <div class="col-sm-9 mb-3">
            <h2 class="text-center mt-3"><?= $this->title  ?></h2>
            <? if (!empty($oem)):?>
            <p class="text-center mt-3">
                <?$engine = Engine::findOne(['Id'=> $modificationSes->IdEngine]);
                $valueEn= ValueEngine::findOne(['Id'=> $modificationSes->IdValueEngine]);?>
                <i><?= $engine->Name . ' ' . $valueEn->Value ?> // </i>

                <span>период выпуска <i><?= $modelsSes->constructioninterval ?></i></span>
            </p>
            <?endif?>
            <?php if (!empty($products)) : ?>

                <div class="row">

                    <?php foreach ($products as $product) : ?>

                        <div class="col-md-4  col-sm-6 ">
                            <div class="product-grid ">
                                <div class="product-image">
                                    <?  
                                    $imgFile=Yii::getAlias('@webroot') . '/img/' . $product['Img'];
                                if (is_file($imgFile)){
                                    $img= Yii::getAlias('@web') . '/img/' . $product['Img'];
                            }else{
                                $img='/img/products/defult_prodact.jpg';
                                
                            }
                                   // $img='products/defult_prodact.jpg';
                                // if ($product['Img']){
                                //             $img=$product['Img'];
                                //     }?>
                                    <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $product['Id'], 'class' => 'image']) ?>">
                                        <?= Html::img($img, ['alt' => 'Product', 'class' => 'pic ', 'title' =>  $product['MetaTitle']]) ?>

                                    </a>

                                    <ul class="social">
                                        <? 
                                            if (!($wishlist['products'][ $product['Id']])):
                                        ?>

                                        <li><a href="<?= yii\helpers\Url::to(['autoshop/search',  'wish' => 'add', 'id' => $product['Id']]) ?>" data-tip="Add to Wishlist"><i class="fa fa-lg fa-heart-o"></i></a></li>
                                        <? else : ?>
                                        <li><a href="<?= yii\helpers\Url::to(['autoshop/search', 'wish' => 'del', 'id' => $product['Id']]) ?>" data-tip="Del from Wishlist"><i class="fa fa-lg fa-heart"></i></a></li>
                                        <? endif ?>
                                    </ul>
                                </div>
                                <div class="product-content">
                                    <h3 class="title overflow-hidden"><a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' =>  $product['Id']]) ?>"><?= $product['Name'] ?></a></h3>
                                    <div class="price"><?= $product['Price'] ?> грн </div>

                                    <div>
                                        <? $nal = 0;
                                        
                                            if ($carts == []) {
                                                $nal = 0;
                                            } else {
                                                foreach ($carts['products'] as $cart) {
                                                    if ($cart['Id'] == $product['Id']) {
                                                        $nal = 1;
                                                    }
                                                }
                                            }
                                            
                                            ?>
                                        <?if ($product['Status']==10):?>
                                        <? if ($nal == 0) : ?>
                                        <a class="add-to-cart" href="<?= yii\helpers\Url::to(['autoshop/search', 'addCart' => 'add', 'id' => $product['Id'],]) ?>">
                                            <i class="fa fa-shopping-cart"></i> <span>Купить</span>
                                        </a>
                                        <? else : ?>
                                        <a class="add-to-cart" href="<?= yii\helpers\Url::to(['autoshop/search', 'delCart' => 'del', 'id' => $product['Id']]) ?>">
                                            <i class="fa fa-shopping-cart"></i> <span>Удалить</span>
                                        </a>
                                        <? endif ?>
                                        <? endif ?>
                                        <?if ($product['Status']==0):?>
                                        <p>Товара нет в наличии</p>
                                        <? endif ?>
                                    </div>

                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
                <?= LinkPager::widget(['pagination' => $pages]); /* постраничная навигация */ ?>
            <?php else : ?>
                <p>По вашему запросу ничего не найдено.</p>
            <?php endif; ?>






        </div>
    </div>
</div>
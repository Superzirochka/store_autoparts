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
use app\models\ZakazProducts;
use app\models\Carts;
use app\models\Reviews;
use app\models\Category;
use app\models\Engine;
use app\models\ValueEngine;
use app\models\NodeAuto;


$this->title = 'Результаты поиска по каталогу ' . $modelsSes->FullName;
$kursItem = $kurs->Current_kurs;
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
                    <div class="col-sm-12">
                        <?php foreach ($products as $product) : ?>

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
                                                foreach ($carts['products'] as $cart) {
                                                    if ($cart['Id'] == $product['Id']) {
                                                        $nal = 1;
                                                    }
                                                }
                                            }
                                           
                                            ?>
                                        <? if ($nal == 0) : ?>
                                        <a class="add-to-cart " href="<?= yii\helpers\Url::to([
                                                                            'autocatalog/search',
                                                                            'addCart' => 'add', 'id' => $product['Id'],
                                                                            'count' => $product['MinQunt']
                                                                        ])
                                                                        ?>">
                                            <i class="fa fa-shopping-cart"></i> <span>Купить</span>
                                        </a>
                                        <? else : ?>
                                        <a class="add-to-cart" href="<?= yii\helpers\Url::to([
                                                                            'autocatalog/search',

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
                              
                                array_push($analogs, $product['Name']);
                             
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
                                    <div class="col-md-2 ">
                                        <hr>

                                        <h5 class="card-title mt-4"><?= $zakazItem->ProductName ?></h5>

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
                                                    if ($cart['Name'] == $product['ProductName']) {
                                                        $nalZakaz = 1;
                                                    }
                                                }
                                            }
                                           
                                            ?>
                                        <? if ($nalZakaz == 0) : ?>
                                        <a class="add-to-cart mt-3" href="<?= yii\helpers\Url::to([
                                                                                '/search',
                                                                                'addZakaz' => 'add', 'id' => $product['Id'],
                                                                                'count' => $product['MinQunt']
                                                                            ])
                                                                            ?>">
                                            <i class="fa fa-shopping-cart"></i> <span>Купить</span>
                                        </a>
                                        <? else : ?>
                                        <a class="add-to-cart mt-3" href="<?= yii\helpers\Url::to([
                                                                                'autoshop/search',

                                                                                'delZakaz' => 'del', 'id' => $product['Id']
                                                                            ]) ?>">
                                            <i class="fa fa-shopping-cart"></i> <span>Удалить</span>
                                        </a>
                                        <? endif ?>
                                        <? endif ?>
                                    </div>
                                </div>
                                <?endforeach?>

                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?= LinkPager::widget(['pagination' => $pages]); /* постраничная навигация */ ?>
                    <?elseif(!empty($zakaz_products)):?>
                    <?print_r($zakaz_products)?>
                    <? foreach($zakaz_products as $zakazItem):
                                ?>

                    <div class="row no-gutters product-grid mb-2">

                        <div class="col-md-1">
                        </div>

                        <div class="col-md-1">
                            <hr>

                            <?//= Html::img($zakazItem->Img, ['alt' => $zakazItem->Description, 'class' => 'pic ', 'title' => $zakazItem->Description]) ?>
                            <p class="card-text mt-4"><?= $zakazItem['Brand'] ?></p>

                        </div>
                        <div class="col-md-2 ">
                            <hr>

                            <h5 class="card-title mt-4"><?= $zakazItem['ProductName'] ?></h5>

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

                            <?if( $zakazItem['Count'] > 0):?>
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
                            <? if ($nal == 0) : ?>
                            <a class="add-to-cart mt-3" href="<?= yii\helpers\Url::to([
                                                                    'autoshop/search',
                                                                    'addCart' => 'add', 'id' => $product['Id'],
                                                                    'count' => $product['MinQunt']
                                                                ])
                                                                ?>">
                                <i class="fa fa-shopping-cart"></i> <span>Купить</span>
                            </a>
                            <? else : ?>
                            <a class="add-to-cart mt-3" href="<?= yii\helpers\Url::to([
                                                                    'autoshop/search',

                                                                    'delCart' => 'del', 'id' => $product['Id']
                                                                ]) ?>">
                                <i class="fa fa-shopping-cart"></i> <span>Удалить</span>
                            </a>
                            <? endif ?>
                            <? endif ?>
                        </div>
                    </div>
                    <?endforeach?>
                <?php else : ?>
                    <p>По вашему запросу ничего не найдено.</p>
                <?php endif; ?>
                </div>





        </div>
    </div>
</div>
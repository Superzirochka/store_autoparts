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
                                $wishlist=[];
                            } else {
                                $wishlist=$session->get('wish_auto');
                            }
                            if (!($wishlist['products'][$item->Id])):
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
                            <?  $imgProd='products/defult_prodact.jpg';
                            if ($item->Img){                                           
                                $imgProd = $item->Img;
                                }?>

                            <a href="img/<?= $imgProd ?>" class="gallery2 toch-photo" data-fancybox="images">
                                <?= Html::img('@web/img/' . $imgProd, ['alt' => 'Product', 'data-imagezoom' => 'true', 'class' => 'picItem']) ?>

                            </a>

                        </div>

                    </div>

                    <div class="itemGallery">
                        <hr>
                        <?if (!$item->Img2){
                                            $imgProd2='products/defult_prodact.jpg';
                                }else{$imgProd2=$item->Img2;}?>
                        <a href="img/<?= $imgProd2 ?>" class="gallery2" rel="group" data-fancybox="images">
                            <?= Html::img('@web/img/' . $imgProd2, ['alt' => 'Product', 'data-imagezoom' => 'true', 'class' => 'picG']) ?>
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
                    <?if (!$item->Tegs){
                        $tegsName='  нет дополнительных критериев для поиска';
                        }else{$tegsName=$item->Tegs;} ?>
                    <p>Теги поиска: <br><?= $tegsName ?></p>

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
                    <div class="d-flex flex-row bd-highlight mb-3">
                        <div>
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                <span class="rating">

                                    <? for ($a = 0; $a < $stars; $a++) : ?>
                                    <i class="fa fa-star" id='stars'></i>
                                    <? endfor ?>

                                    <? if ($stars < 5) : ?>
                                    <? for ($i = $stars; $i < 5; $i++) : ?>
                                    <i class="fa fa-star-o" id='stars'></i>
                                    <? endfor ?>
                                    <? endif ?>

                                </span>
                                <i class="mycolor"> <?= $countRew ?> отзыв </i></a>
                        </div>
                        <div>

                            <a class="nav-link mycolor" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"> Написать отзыв</a>



                        </div>
                    </div>
                    <hr />

                    <div class="about-product my-shadow">
                        <div class="current-price ">
                            <p>Цена: <span><i class="mycolor"> <?= $item->Price ?></i></span> <b><?= $current['Name'] ?></b></p>
                            <p class="text-danger">Цена указана за <?= $item->Units ?></p>
                        </div>
                        <div class="item-stock">
                            <i> Наличие:
                                <?if ($item->Status != 0):?>
                                <b class="text-stock"><?= $item->Availability ?></b>
                                <? endif?>
                            </i>
                            <br>
                            <i> Минимальный заказ: <b class="text-stock"><?= $item->MinQunt ?></b></i>
                        </div>


                        <?php $form = ActiveForm::begin(['options' => ['class' => 'is-invalid', 'method' => 'POST']]); ?>
                        <?= $form->field($form_quant, 'quant')->textInput(['placeholder' => $item->MinQunt, 'type' => 'number', 'value' => $item->MinQunt, 'id' => 'quant', 'autofocus' => true])->label('Количество'); ?>
                        <div class="btn-group">
                            <?if ($item->Status == 0){
                                echo 'Товара нет в наличии';
                            }?>

                            <?if ($item->Status != 0):?>
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



                            <?endif?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>

                </div>

            </div>
            <!--Вкладки  -->
            <div class="row mt-5 pt-5">

                <div class="col-sm-12">
                    <ul class="nav nav-tabs nav-fill flex-column flex-sm-row" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active mycolor" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                                <h4>Описание товара</h4>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mycolor" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                <h4>Отзывы (<?= count($reviews) ?>)</h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mycolor" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                                <h4>Написать отзыв</h4>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <?= $item->Description ?>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="table-responsive-sm">
                                <table class="table">
                                    <? if (empty($reviews))
                                    echo 'Пока отзывов нет';

                                    ?>

                                    <? foreach ($reviews as $rev) : ?>
                                    <tr>
                                        <th scope="col" style="width:25%"><?= $rev->Name ?></th>
                                        <th scope="col" style="width:50%"><strong> <?= $rev->Title ?></strong></th>
                                        <th scope="col" style="width:25%"><strong>
                                                <span class="d-flex flex-row-reverse ">
                                                    <? for ($a = 1; $a <= $rev->Raiting; $a++) : ?>
                                                    <i id='stars' class="fa fa-star"></i>
                                                    <? endfor ?>
                                                    <? if ($rev->Raiting < 5) : ?>
                                                    <? for ($i = $rev->Raiting; $i < 5; $i++) : ?>
                                                    <i id='stars' class="fa fa-star-o"></i>
                                                    <? endfor ?>
                                                    <? endif ?></span></strong></th>

                                    </tr>
                                    <!--ряд с ячейками заголовков-->
                                    <tr>
                                        <td><i> <?= $rev->Date_add ?></i></td>
                                        <td colspan="2">

                                            <?= $rev->Review ?></td>

                                    </tr>
                                    <!--ряд с ячейками тела таблицы-->
                                    <? endforeach ?>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php $form = ActiveForm::begin(['options' => ['class' => 'is-invalid', 'method' => 'POST']]) ?>
                                    <fieldset>
                                        <legend>Написать отзыв</legend>
                                        <div class="form-group">
                                            <?= $form->field($form_review, 'name')->textInput(['value' => $customer['FName']])->hint('Пожалуйста, введите имя')->label('Имя'); //$customer['FName']
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <?= $form->field($form_review, 'title')->textInput()->hint('Пожалуйста, введите тему')->label('Тема'); ?>
                                        </div>
                                        <div class="form-group">
                                            <?= $form->field($form_review, 'review')->textArea()->hint('Оставте свой отзыв о товаре')->label('Отзыв'); ?>
                                        </div>

                                        <?= $form->field($form_review, 'raiting')->radioList(['1' => 'очень плохо', '2' => 'плохо', '3' => 'нормально', '4' => 'хорошо', '5' => 'отлично']); ?>
                                        <div class="buttons clearfix">
                                            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-lg btn-block']) ?>

                                        </div>
                                    </fieldset>

                                    <?php ActiveForm::end() ?>




                                </div>
                            </div>
                        </div>
                    </div>

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
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\OrderItem;
use app\models\Products;

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container my-shadow " id="content_box">
    <h1 class="text-center"><?= $this->title ?></h1>
    <div class="row">
        <div class="col-sm-12" id="User">
            <ul class="nav nav-pills list-group-item-primary m-0" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active text-dark" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Заказы</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-dark" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Список желаний</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link  text-dark" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Контактная информация</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-dark" href="<?= yii\helpers\Url::to(['autoshop/exit']) ?>">Выход</a>
                </li>
            </ul>
        </div>

        <div class="tab-content col-sm-12" id="pills-tabContent">
            <div class="tab-pane fade " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                <div class="col-sm-12">
                    <h4 class="text-center">Редактирование контактных данных</h4>
                    <?php $form = ActiveForm::begin([
                        'options' => ['class' => 'my-shadow mt-1 mb-3', 'method' => 'POST', 'id' => 'account-form']
                    ]); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <?= $form->field($model, 'nameuser')->textInput(['value' => $user->FName]) ?>
                            <?= $form->field($model, 'sername')->textInput(['value' => $user->LName]) ?>
                            <?= $form->field($model, 'email')->textInput(['value' => $user->Email]) ?>
                            <?= $form->field($model, 'phone')->textInput(['value' => $user->Phone]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'city')->textInput(['value' => $user->City]) ?>
                            <?= $form->field($model, 'adres')->textInput(['value' => $user->Adres]) ?>

                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'login')->textInput(['value' => $user->Login]) ?>
                            <?= $form->field($model, 'password')->passwordInput(['value' => $user->Password]) ?>
                            <?
                        if ($user->News == 1){
                        $checked= 'true';
                        }else {
                            $checked= 'false';
                        }
                         ?>
                            <?= $form->field($model, 'news')->checkbox(['checked ' => $checked]) ?>
                        </div>
                    </div>





                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>


            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="col-sm-12">
                    <div class="Wishlist-area mb-5">
                        <h2 class="text-center mb-5 mt-2">Список желаний</h2>
                        <h3 class="text-center mb-3"><?= $messageWish ?></h3>
                        <? if ( $messageWish ==''):?>
                        <div class="table-responsive-sm">

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-center">Изображение</td>
                                        <td class="text-center">Код товара</td>
                                        <td class="text-center">Название</td>
                                        <td class="text-center">Минимальный заказ</td>
                                        <td class="text-center">Цена</td>
                                        <td class="text-right"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? foreach ($products as $item) : ?>
                                    <tr>
                                        <td class="text-center align-middle">
                                            <a href="#"><?= Html::img('@web/img/' . $item->Img, ['alt' => 'Product', 'width' => '50px']) ?></a>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $item->Id]) ?>"><?= $item->Name ?></a>
                                        </td>
                                        <td class="text-center align-middle"><?= $item->MetaDescription ?></td>
                                        <td class="text-center align-middle"><?= $item->MinQunt ?></td>
                                        <td class="text-center align-middle">

                                            <span><?= $item->Price ?> <?= $current->Name ?></span>

                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="<?= yii\helpers\Url::to(['autoshop/account', 'id' => $item->Id, 'add' => 'add']) ?> " type="button" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="Add to Cart">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                            <a href="<?= yii\helpers\Url::to(['autoshop/account', 'id' => $item->Id, 'del' => 'delete']) ?>" class="btn btn-danger" data-toggle="tooltip" title="" data-original-title="Remove">

                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <? endforeach ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-around">

                            <a href="<?= yii\helpers\Url::to(['autoshop/list']) ?>" class="btn w-25 btn-primary">Продолжить покупки</a>
                            <a href="<?= yii\helpers\Url::to(['autoshop/account', 'clear' => 'clear']) ?>" class="btn  btn-danger w-25">Очистить список</a>
                        </div>
                        <?else :?>
                        <a href="<?= yii\helpers\Url::to(['autoshop/list']) ?>" class="btn btn-block btn-primary mt-5">Назад </a>
                        <?endif?>

                    </div>

                    <div class="row">
                        <!--рекомендованный товар-->
                        <?= app\components\Recomendprod::widget() ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show active" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <h2 class="text-center mb-5 mt-2">Ваши заказы</h2>
                <? if (count($orderUser)== 0):?>
                <h2 class="text-center mb-5 mt-2">Вы пока не сделали ни одного заказа</h2>
                <?else:?>

                <? foreach ($orderUser as $order):?>
                <?
                                    switch($order->Status){
                                        case 'new':
                                            $status= 'Новый';
                                        break;
                                        case 'processed':
                                            $status='Обработан';
                                        break;
                                        case 'paid':
                                            $status= 'Оплачен';
                                        break;
                                        case 'delivered':
                                            $status= 'Доставлен';
                                        break;
                                        case 'completed':
                                            $status= 'Завершен';
                                        break;
                                        default:
                                        $status= 'Ошибка';
                                    break;
                                }
                                    ?>
                <? 
                        $orderItems= OrderItem::find()->where(['IdOrder'=> $order->OrderNumber])->all();    
                        ?>
                <div class="row">
                    <div class="table-responsive-sm col-sm-12">
                        <div class="row">
                            <div class="col-sm-5 text-left">
                                <h5>Номер заказа: <span><b><?= $order->OrderNumber ?></b></span></h5>
                            </div>
                            <div class="col-sm-4">
                                <h5> Дата: <span><?= $order->DateAdd ?> </span></h5>
                            </div>
                            <div class="col-sm-3 text-right">
                                <h5>Статус: <span> <?= $status ?> </span> </h5>
                            </div>
                        </div>

                        <table class="table table-borderless table-hover mt-3 mb-5">
                            <tbody>
                                <?foreach($orderItems as $item):
                                    ?>
                                <?
                                       $itemProd = Products::find()->where(['Id'=>$item->IdProduct])->one(); 
                                        ?>
                                <tr>
                                    <td class="text-center align-middle">
                                        <a href="#"><?= Html::img('@web/img/' . $itemProd->Img, ['alt' => 'Product', 'width' => '50px']) ?></a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?= yii\helpers\Url::to(['autoshop/view', 'id' => $itemProd->Id]) ?>">код товара: <?= $itemProd->Name ?></a>
                                    </td>
                                    <td class="text-center align-middle"><?= $itemProd->MetaDescription ?></td>
                                    <td class="text-center align-middle"><?= $item->Quanty ?> <?= $itemProd->Units ?></td>
                                    <td class="text-center align-middle"><?= $item->Price ?></td>
                                    <td class="text-center align-middle"><?= $item->Cost ?></td>
                                </tr>
                                <?endforeach?>
                            </tbody>
                            <tfoot>
                                <tr class="table-secondary">
                                    <td colspan="4"></td>
                                    <td class="text-center align-middle">Всего</td>
                                    <td class="text-center align-middle"><?= $order->Amount ?>грн.</td>
                                </tr>
                                <tr>

                                    <td class="text-center align-middle">
                                        <i> Оплата</i>
                                    </td>
                                    <?
                                    switch($order->IdOplata){
                                        case 1: $pay ='Наличный расчет';
                                    break;
                                    case 2: $pay ='Безналичный расчет';
                                break;
                                case 3: $pay ='Наложенный платеж';
                                break;
                                default:
                                $pay='';
                                    }

                                    ?>
                                    <td class="text-left align-middle"><i><?= $pay ?></i></td>
                                    <td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle"><i> Доставка</i></td>
                                    <td class="text-left align-middle"><i> <?= $order->City ?></i></td>
                                    <td class="text-left align-middle">
                                        <i> <?= $order->Adress ?></i>
                                    </td>
                                    <td colspan="3"></td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle"><i>Комментарий: </i></td>
                                    <td colspan="5" class="text-left align-middle"><?= $order->Comment ?></td>
                                </tr>
                            </tfoot>
                        </table>
                        <hr>


                    </div>

                </div>
                <?endforeach?>
                <? endif?>
            </div>
        </div>


    </div>

</div>
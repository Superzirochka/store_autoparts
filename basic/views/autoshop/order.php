<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\Products;
use app\models\Wishlist;
use app\models\Carts;
use app\models\Dostavka;
use app\models\Oplata;
use app\models\Customers;
use yii\widgets\Pjax;
use app\models\ZakazProducts;

$this->title = 'Оформить заказ';
$this->params['breadcrumbs'][] = $this->title;
$today = date("Y-m-d");
$session = Yii::$app->session;
$session->open();
$customer = $session->get('customer');
if ($customer['Id'] != 1) {
    $userOrder = Customers::find()->where(['Id' => $customer['Id']])->one();
}
?>

<div class="container my-shadow " id="content_box">
    <div class="row">
        <div class="col-md-3">
            <?= app\components\CategoryWidget::widget() ?>
            <!-- <?= app\components\BrandWidget::widget() ?> -->
        </div>
        <div class="col-md-9">
            <h2 class="text-center"><?= $this->title ?></h2>

            <div class="row">
                <div class="table-responsive col-md-12 mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="text-left">Код товара</td>
                                <td class="text-left">Название</td>
                                <td class="text-left">Наличие</td>
                                <td class="text-left">Количество</td>
                                <td class="text-right">Цена</td>
                                <td class="text-right">Сумма</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?if (!empty($carts['products'])):?>
                            <? foreach ($carts['products'] as $cart) : ?>
                            <? $item = Products::findOne($cart['Id']) ?>
                            <tr>
                                <td class="text-left align-middle">
                                    <?= $cart['Name'] ?></a>
                                </td>

                                <td class="text-left align-middle "><?= $item->MetaDescription ?>
                                </td>
                                <td class="text-center align-middle">в наличии</td>
                                <td class="text-left align-middle ">
                                    <?= $cart['Quanty'] ?><i> * <?= $item->Units ?></i>

                                </td>
                                <td class="text-right align-middle"><b><?= $cart['Price'] ?> </b><i><?= $current['Name'] ?></i></td>
                                <td class="text-right align-middle"><b>
                                        <?= $cart['Price'] * $cart['Quanty'] ?> </b><i><?= $current['Name'] ?></i></td>
                            </tr>
                            <? endforeach ?>
                            <?endif?>
                            <?if (!empty($carts['zakaz'])):?>
                            <?foreach($carts['zakaz'] as $cart):?>
                            <? $zakaz=ZakazProducts::findOne($cart['Id']);?>
                            <tr>
                                <td class="text-left align-middle">
                                    <?= $cart['ProductName'] ?>
                                </td>

                                <td class="text-left align-middle "><?= $zakaz->Description ?>

                                </td>
                                <td class="text-center align-middle"><?= $zakaz->TermsDelive ?></td>
                                <td class="text-left align-middle ">
                                    <?= $cart['Quanty'] ?>
                                </td>
                                <td class="text-right align-middle"><b><?= $cart['Price'] ?> </b><i><?= $current['Name'] ?></i></td>
                                <td class="text-right align-middle"><b>
                                        <? //$sum += $Quanty * $item->Price 
                                                            ?>
                                        <?= $cart['Price'] * $cart['Quanty'] ?>
                                    </b><i><?= $current['Name'] ?></i></td>
                            </tr>
                            <?endforeach?>
                            <?endif?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" scope="col" colspan="3">
                                    <strong>Итого:</strong>
                                </td>
                                <td class="text-right" scope="col" colspan="3"><b><?= $carts['amount'] ?> </b><i> <?= $current->Name ?></i></td>
                            </tr>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <? Pjax::begin([
    // Опции Pjax 
])?>
            <?php $form = ActiveForm::begin(
                ['options' => ['data' => ['pjax' => true]]]
            ); ?>

            <div class="row">
                <div class="col-sm-12">
                    <hr>
                    <p><b class="text-danger">*</b> поля обязательные для заполнения</p>

                </div>
                <!-- Start Shipping -->
                <div class="col-sm-4">
                    <h4>
                        Информация о доставке
                    </h4>
                    <div class="">

                        <div class="form-horizontal ">
                            <div class="form-group mb-5 ">
                                <?= $form->field($order_form, 'shiping')->dropdownList(
                                    Dostavka::find()->select(['Name', 'Id'])->indexBy('Id')->orderBy('Name ASC')->column(),
                                    ['prompt' => 'Выберите способ доставки', 'class' => 'form-control mb-0', 'id' => 'shiping']
                                )->label('Выберите способ доставки'); ?>
                                <?php
                                $js = <<<JS
    $('#shiping').on('change', function(){
        let data = $(this).val();
        $.ajax({
            url: 'order',
            type: 'GET',
          //  dataType : 'json',
            data:{'data' : data},
            
            success: function(res){
              $("#shipingCity").val(res);
              if (res == 'Харьков'){
                $("#adress").val('Авторынок Автоград, пр. Л.Ландау 2-б, 4 ряд 31 магазин');
              }else {
                $("#adress").val('');
              }
               // console.log(res);
            },
            error: function(){
                //let statusCode = request.status;
                console.log('Error!'+data);
            }
        });
        return false;
    });
JS;

                                $this->registerJs($js);
                                ?>

                            </div>
                            <div class="form-group mb-5 ">

                                <?= $form->field($order_form, 'shipingCity')->textInput([
                                    //'placeholder' => '---',
                                    'type' => 'text',  'class' => 'form-control', 'value' => $userOrder->City, 'id' => 'shipingCity'
                                ])->label('Город доставки'); ?>
                                <!-- <?php
                                        $js = <<<JS
    $('#shipingCity').on('propertychange', function(){
        let data = $(this).val();
        $.ajax({
            url: 'order',
            type: 'GET',
          //  dataType : 'json',
            data:{'city' : data},
            
            success: function(res){
             $("#adress").val(res);
            

                console.log('city'+data);
            },
            error: function(){
                //let statusCode = request.status;
                console.log('Error!'+data);
            }
        });
        return false;
    });
JS;

                                        $this->registerJs($js);
                                        ?> -->

                                <?= $form->field($order_form, 'adress')->textInput([
                                    'placeholder' => 'отделение новой почты №65', 'type' => 'text',  'class' => 'form-control', 'id' => 'adress',
                                    'value' => $userOrder->Adres
                                ])->label('Адрес доставки'); ?>

                                <?= $form->field($order_form, 'note')->textArea(['placeholder' => 'Коментарий', 'cols' => '30', 'rows' => '10',  'class' => 'form-control'])->label('Номер отделения новой почты'); ?>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- Start Shipping -->
                <!-- Start payment -->
                <div class="col-sm-4">
                    <h4 class="">
                        Оплата
                    </h4>

                    <div class=" mb-5 ">
                        <?= $form->field($order_form, 'cash')->dropdownList(
                            Oplata::find()->select(['Name', 'Id'])->indexBy('Id')->orderBy('Name ASC')->column(),
                            ['prompt' => 'Выберите способ оплаты', 'class' => 'form-control mb-0']
                        )->label('Выберите способ оплаты'); ?>

                    </div>

                </div>
                <!-- Start payment -->
                <!-- Start contact -->
                <div class="col-sm-4">

                    <div>
                        <div>
                            <h4>
                                Контактная информация
                            </h4>
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <?= $form->field($order_form, 'name')->textInput([
                                        'placeholder' => 'Иван',
                                        'id' => 'name', 'class' => 'form-control',
                                        'value' => $userOrder->FName
                                    ])->label('Имя'); ?>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?= $form->field($order_form, 'lastname')->textInput([
                                        'placeholder' => 'Иванов', 'id' => 'lastname', 'class' => 'form-control',
                                        'value' => $userOrder->LName
                                    ])->label('Фамилия'); ?>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?= $form->field($order_form, 'email')->textInput([
                                        'placeholder' => 'adres@i.ua', 'type' => 'email', 'id' => 'email', 'class' => 'form-control',
                                        'value' =>  $userOrder->Email
                                    ])->label('Email'); ?>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?= $form->field($order_form, 'phone')->textInput([
                                        'placeholder' => '+38(057)123-45-67', 'type' => 'tel', 'id' => 'phone', 'class' => 'form-control',
                                        'value' => $userOrder->Phone
                                    ])->label('Номер телефона'); ?>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <?= $form->field($order_form, 'mailing')->checkbox(['value' => 1, 'checked' => true]) ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Start contakt -->
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-between">
                    <a href="#" class="btn  btn-inline-block w-25" onclick=" javascript:history.back();" id='myBackgra'>Продолжить покупки</a>
                    <?= Html::submitButton('Оформить', ['class' => 'btn btn-inline-block w-25', 'id' => 'myBackgra']) ?>

                </div>
            </div>


            <?php ActiveForm::end(); ?>
            <? Pjax::end();?>
        </div>
    </div>
</div>
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use app\assets\AppAsset;


?>
<div id="fixed_sidebar" class="row">
    <div id="sidebar-collapse" class="col-sm-12 sidebar ">
        <ul class="nav navbar-nav ">
            <li class="pt-3">
                <a href="<?= Url::to(['/admin/default/index']) ?>" class="h5 mymain"><span class="glyphicon-dashboard"></span> Главная</a>
            </li>

            <li class="pt-3"><a href="<?= Url::to(['/admin/category/index']) ?>" class="h5 mymain"><span class="glyphicon glyphicon-list-alt"></span>Категории</a></li>
            <li class="pt-3"><a href="<?= Url::to(['/admin/brandprod/index']) ?>" class="h5 mymain"><span>&#x2122;</span> Бренды</a></li>
            <li class="pt-3"><a href="<?= Url::to(['/admin/supplier/index']) ?>" class="h5 mymain"><span>&#128423;</span> Поставщики</a></li>
            <li class="pt-3">
                <div class=" dropdown">
                    <a class="dropdown-toggle h5 mymain " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-th"></span> Товары
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?= Url::to(['/admin/products/index']) ?>" class="h5 mymain"><span>♲</span> Товары из наличия</a>
                        <a class="dropdown-item" href="<?= Url::to(['/admin/zakaz-products/index']) ?>" class="h5 mymain"><span>&#128472;</span>Заказные товары</a>
                    </div>
                </div>
            </li>
            <li class="pt-3">
                <div class=" dropdown">
                    <a class="dropdown-toggle h5 mymain " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">&#128413; Заказы
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?= Url::to(['/admin/order-shop/index']) ?>"><span class="glyphicon glyphicon-th"></span> Заказы</a>
                        <a class="dropdown-item" href="<?= Url::to(['/admin/zakaz/index']) ?>"> <span>&#128393;</span> Запросы</a>
                    </div>
                </div>
            </li>


            <li class="pt-3"><a href="<?= Url::to(['/admin/customers/index']) ?>" class="h5 mymain"><span>&#128101;</span> Покупатели</a></li>

            <!-- <li class="pt-3"><a href="#" class="h5 mymain"><span>&#128491;</span> Отзывы</a></li> -->
            <li class="pt-3"><a href="<?= Url::to(['/admin/mailcontact/index']) ?>" class="h5 mymain"><span>&#128388;</span> Сообщения</a></li>


            <li class="pt-3">
                <div class="dropdown">
                    <a class="dropdown-toggle h5" href="#" role="button" id="settingMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>
                            &#9881;</span> Настройки
                    </a>
                    <div class="dropdown-menu" aria-labelledby="settingMenu">
                        <a href="<?= Url::to(['/admin/store/index']) ?>" class="dropdown-item"><span class="glyphicon glyphicon-info-sign"></span> Магазины</a>
                        <a href="<?= Url::to(['/admin/menu/index']) ?>" class="dropdown-item"><span>&#8251; </span> Меню</a>
                        <a href="<?= Url::to(['/admin/page/index']) ?>" class="dropdown-item"><span>&#128861;</span> Страницы</a>
                        <a href="<?= Url::to(['/admin/banner/index']) ?>" class="dropdown-item"><span>&#128443;</span> Слайдеры</a>
                        <a href="<?= Url::to(['/admin/actions/index']) ?>" class="dropdown-item"><span>&#10031;</span> Акции</a>

                    </div>

                </div>
            </li>
            <li class="pt-3">
                <div class="dropdown">
                    <a class="dropdown-toggle h5" href="#" role="button" id="settingAuto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>
                            &#9933;
                        </span> Автокаталог
                    </a>
                    <div class="dropdown-menu" aria-labelledby="settingAuto">
                        <a href="<?= Url::to(['/admin/manufacturerauto/index']) ?>" class="dropdown-item"><span>
                                &#174;</span> Марки авто</a>
                        <a href="<?= Url::to(['/admin/analog/index']) ?>" class="dropdown-item"><span>&#8251; </span>Аналоги OEM</a>
                        <!--   <a href="<?= Url::to(['/admin/page/index']) ?>" class="dropdown-item"><span>&#128861;</span> Страницы</a>
                        <a href="<?= Url::to(['/admin/banner/index']) ?>" class="dropdown-item"><span>&#128443;</span> Слайдеры</a>
                        <a href="<?= Url::to(['/admin/actions/index']) ?>" class="dropdown-item"><span>&#10031;</span> Акции</a> -->

                    </div>

                </div>
            </li>
            <li role="presentation" class="divider"></li>
            <li><a href="<?= yii\helpers\Url::to(['auth/logout']) ?>" class="h4 mymain"><span class="glyphicon glyphicon-user"></span> Выход</a></li>
        </ul>
    </div>
</div>
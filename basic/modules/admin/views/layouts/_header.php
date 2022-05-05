<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\modules\admin\models\OrdersShop;
use app\modules\admin\models\Zakaz;


$newZakaz = Zakaz::find()->select('Id', 'MarkaAuto', 'ModelAuto', 'YearCon', 'ValueEngine', 'VIN', 'Description', 'FIO', 'Email', 'Phone', 'DateAdd', 'Status')->where(['Status' => 'new'])->all();
$countNew = count($newZakaz);
$allZakaz = Zakaz::find()->select('Id', 'MarkaAuto', 'ModelAuto', 'YearCon', 'ValueEngine', 'VIN', 'Description', 'FIO', 'Email', 'Phone', 'DateAdd', 'Status')->all();
$countAll = count($allZakaz);

$newOrder = OrdersShop::find()->select('Id', 'OrderNumber', 'IdUser', 'Name', 'LastName', 'Email', 'Phone', 'City', 'IdDostavka', 'Comment', 'Amount', 'Status', 'DateAdd', 'DateUpdate', 'IdOplata', 'Mailing', 'Adress')->where(['Status' => 'new'])->all();
$countOrder = count($newOrder);

?>

<nav class="navbar navbar-inverse fixed-top pl-0" role="navigation">

    <div class="container-fluid">

        <div class="navbar-header">
            <div class="row">
                <div class="col-sm-5 pl-0">

                    <?= Html::button('<span class="navbar-toggler-icon text-white"></span>', [
                        'class' => 'navbar-toggler collapsed hidden ',
                        'data-toggle' => 'collapse',
                        'data-target' => '#sidebar-collapse',
                        'aria-controls' => 'sidebar-collapse',
                        'aria-label' => 'Toggle navigation'
                    ]) ?>

                    <a class="navbar-brand" href="<?= Url::to(['/admin/default/index']) ?>"><span>Панель </span>управления</a>
                </div>
                <div class="col-sm-4 mt-2 ">
                    <form class="form-inline my-2 my-lg-0" id="searchForm" method="get" action="<?= Url::to(['products/search']); ?>">
                        <input class="form-control mr-sm-2" type="search" name="query" placeholder="Поиск" aria-label="Search">
                        <!-- <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Поиск</button> -->
                    </form>

                </div>
                <div class="col-sm-1 mt-3">
                    <!-- заказы -->

                    <a class="" href="<?= Url::to(['/admin/order-shop/index']) ?>" title="Новые заказы">
                        <span> &#128722;</span> <span class="label text-danger"><?= $countOrder ?> </span>
                    </a>
                </div>

                <div class="col-sm-1 pt-2 ">
                    <ul class="nav navbar-top-links navbar-right">
                        <li class="dropdown">
                            <!-- запросы -->
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" title="Запросы">
                                <span class="glyphicon glyphicon-envelope"></span> <span class="label label-primary "></span><span class="text-danger"><?= $countNew ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-alerts">
                                <li>
                                    <a href="<?= Url::to(['/admin/zakaz/index']) ?>">
                                        <div>
                                            <em class="glyphicon glyphicon-envelope"></em> <span class="text-danger"><?= $countNew ?> Новые запросы</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/admin/zakaz/index']) ?>">
                                        <div>
                                            <em class="glyphicon glyphicon-envelope "></em> <?= $countAll ?> Все запросы
                                        </div>
                                    </a>
                                </li>

                            </ul>
                        </li>

                </div>
                <div class="col-sm-1 pt-3">
                    <a href="<?= yii\helpers\Url::to(['/autoshop/index']) ?>" class="mt-1" target="_blank">Магазин</a>
                    <!-- <a href="<?= yii\helpers\Url::to(['auth/logout']) ?>" class="mt-1">Выход</a> -->
                </div>
            </div>

        </div>
    </div><!-- /.container-fluid -->
</nav>
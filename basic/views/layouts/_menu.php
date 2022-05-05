<?php

use app\models\Menu;
use yii\helpers\Url;
use yii\helpers\Html;

$lang = 1;
$menu = Menu::find()->select('Id, NameMenu, Title, Link,  Sort, Content, Id_lang,Id_parentMenu')->where(['Id_lang' => $lang])->ORDERBY('Sort')->all();
?>

<div class="container-fluid" id="menu">
    <menu class="container my-navbar">
        <nav class="navbar navbar-expand-lg navbar-dark" id="navbar">
            <a class="hidden" href="<?= Url::home() ?>">МЕНЮ</a>
            <?= Html::button('<span class="navbar-toggler-icon"></span>', [
                'class' => 'navbar-toggler',
                'data-toggle' => 'collapse',
                'data-target' => '#navbarSupportedContent',
                'aria-controls' => 'navbarSupportedContent',
                'aria-expanded' => 'false',
                'aria-label' => 'Toggle navigation'
            ]) ?>


            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <? foreach ($menu as $itemMenu) : ?>
                    <?
                        if ($itemMenu->Id_parentMenu == 0 //$itemMenu->Id_parentMenu
                        ) : ?>
                    <? 
                    $menuDrop = Menu::find()->select('Id, NameMenu, Title, Link,  Sort, Content, Id_lang,Id_parentMenu')->where(['Id_parentMenu' => $itemMenu->Id])->ORDERBY('Sort')->all();
                     
                                if (count($menuDrop)!= 0) {
                                    $znach = 'role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="navbarDropdown' . $itemMenu->Id . '"';
                                    $drop = 'dropdown';
                                    $toggle = 'dropdown-toggle';
                                } else {
                                    $znach = ' ';
                                    $toggle = ' ';
                                    $drop = 'active';
                                }
                           
                            ?>
                    <li class="nav-item <?= $drop ?>">
                        <a class="nav-link h4 <?= $toggle ?>" href="<?= Url::to([$itemMenu->Link], true) ?>" <?= $znach ?>><?= $itemMenu->NameMenu ?> <span class="sr-only">(current)</span></a>
                        <? if (count($menuDrop)!= 0):?>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <? foreach ($menuDrop as $item) : ?>
                            <? //if ($itemMenu->Id == $item->Id_parentMenu & $item->Id != $item->Id_parentMenu) : ?>
                            <a class="dropdown-item h5" href="<?= yii\helpers\Url::to([$item->Link]) ?>"><?= $item->NameMenu ?></a>
                            <div class="dropdown-divider"></div>
                            <?// endif ?>
                            <? endforeach ?>
                        </div>
                        <?endif?>

                    </li>


                    <? $menuDrop = [];?>
                    <? endif ?>
                    <? endforeach ?>


                </ul>

                <form class="form-inline my-2 my-lg-0" id="searchForm" method="get" action="<?= Url::to(['autoshop/search']); ?>">
                    <input class="form-control mr-sm-2" type="search" name="query" placeholder="Поиск" aria-label="Search" required>
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Поиск</button>
                </form>
            </div>
        </nav>
    </menu>
</div>
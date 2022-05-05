<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ShopAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'css/style.css',
        'css/shop.css',
        //  'css/admin.css',
        'css/error.css',

        'css/all.css',
        //'css/bootstrap.min.css',
        "css/jquery.fancybox.min.css",
        "css/owl-carousel/owl.carouselRec.min.css",
        "css/owl-carousel/owl.carousel.min.css",
        "css/owl-carousel/owl.theme.default.min.css",
        "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    ];
    public $js = [
        "js/jquery.min.js",
        "js/jquery-ui.min.js",
        "js/bootstrap.min.js",
        "js/jquery.fancybox.min.js",
        "js/owl-carousel/owl.carousel.js",
        "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js",
        "https://kit.fontawesome.com/985caf78bc.js",
        "js/main.js",
        //  "js/admin.js",
        "js/error.js",
        //   "js/admin/chart.min.js",
        //   "js/admin/chart-data.js",
        //    "js/admin/easypiechart.js",
        //    "js/admin/easypiechart-data.js",
        //   "js/admin/bootstrap-datepicker.js"
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}

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
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/admin.css',
        'css/all.css',
        'css/bootstrap.min.css'
    ];
    public $js = [
        //   "js/jquery.min.js",
        "js/jquery-ui.min.js",
        "js/jquery.fancybox.min.js",
        "js/owl-carousel/owl.carousel.js",
        "https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js",
        "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js",
        "https://kit.fontawesome.com/985caf78bc.js",
        "js/admin.js",
        "js/admin/chart.min.js",
        "js/admin/chart-data.js",
        "js/admin/easypiechart.js",
        "js/admin/easypiechart-data.js",
        "js/admin/bootstrap-datepicker.js"
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}

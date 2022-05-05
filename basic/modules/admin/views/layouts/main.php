<?php
/* @var $this \yii\web\View */
/* @var $content string */
$session = Yii::$app->session;

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use app\assets\AdminAsset;
use app\modules\admin\models\Store;

$session = Yii::$app->session;
$session->open();
//$session->remove('store');
if (!$session->has('auth_site_admin')) {
    $visible = 'd-none';
} else {
    $visible = '';
}
if ($session->has('store')) {
    $store = $session->get('store');
} else {
    $store = Store::find()->select(' Id, Name_shop,  Description, Meta_title, Meta_description, Meta_keyword, Phone, Viber,Facebook_link , Work_time, Email, Adress,Owner, Telegram_link, Google_map, Logo, logo_small, Id_lang, Description_ua, Meta_title_ua, Meta_description_ua, Meta_keyword_ua, Work_time_ua, Info, Adress_ua')->where(['Id' => 1])->one();
    $session->set('store', [
        'Name_shop' => $store->Name_shop,
        'Meta_title' => $store->Meta_title,
        'Meta_description' => $store->Meta_description,
        'Meta_keyword' => $store->Meta_description,
        'Phone' => $store->Phone,
        'Viber' => $store->Viber,
        'Facebook_link' => $store->Facebook_link, 'Adress' => $store->Adress,
        'Telegram_link' => $store->Telegram_link,
        'Logo' => $store->Logo,
        'logo_small' => $store->logo_small, 'Description_ua' => $store->Description_ua,
        'Meta_title_ua' => $store->Meta_title_ua, 'Meta_description_ua' => $store->Meta_description_ua, 'Meta_keyword_ua' => $store->Meta_keyword_ua,
        'Work_time_ua' => $store->Work_time_ua,
        'Info' => $store->Info, 'Adress_ua' => $store->Adress_ua
    ]);
}


AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/img/<?= $store['logo_small'] ?>">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> Панель управления</title>
    <?php $this->head() ?>
</head>

<body id="body-admin">
    <div class="row  <?= $visible ?>">
        <?= $this->render('_header') ?>
    </div>

    <div class="container-fluid pl-0">
        <div class="row ">
            <div class="col-sm-3 col-lg-2 ml-0 pl-0 <?= $visible ?>">
                <?= $this->render('_sidebar') ?>
            </div>
            <div class="col-sm-10 col-sm-offset-2 col-lg-10 col-lg-offset-2 main">
                <div class="row <?= $visible ?> mt-5 pt-3">
                    <nav aria-label="breadcrumb" class="col-md-12 " mt-1 mb-1 ">
                     <?= yii\widgets\Breadcrumbs::widget([
                            // 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'homeLink' => [
                                'label' => 'Главная ',
                                'url' => Url::to(['/admin/default/index']),

                                //любые атрибуты ссылки : class, style, 'title' и т.п.
                            ],
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]) ?>
                    </nav>
                    </div>
                <?php if (Yii::$app->session->hasFlash('warning')) : ?>
                    <div class=" alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p><?= Yii::$app->session->getFlash('warning'); ?></p>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="container ml-5">

                    <?= $content; ?>
                </div>
            </div>

            <div class=" container admin-footer <?= $visible ?>">

                <hr>
                <p class=" text-center mymain"> &copy; <?= Yii::$app->params['shopName'] ?></p>

            </div>
            </div>
        </div>

    </div>


    <script>
        window.onload = function() {
            var chart1 = document.getElementById("line-chart").getContext("2d");
            window.myLine = new Chart(chart1).Line(lineChartData, {
                responsive: true,
                scaleLineColor: "rgba(255,255,255,.2)",
                scaleGridLineColor: "rgba(255,255,255,.05)",
                scaleFontColor: "#ffffff"
            });
            var chart2 = document.getElementById("bar-chart").getContext("2d");
            window.myBar = new Chart(chart2).Bar(barChartData, {
                responsive: true,
                scaleLineColor: "rgba(255,255,255,.2)",
                scaleGridLineColor: "rgba(255,255,255,.05)",
                scaleFontColor: "#ffffff"
            });
            var chart5 = document.getElementById("radar-chart").getContext("2d");
            window.myRadarChart = new Chart(chart5).Radar(radarData, {
                responsive: true,
                scaleLineColor: "rgba(255,255,255,.05)",
                angleLineColor: "rgba(255,255,255,.2)"
            });

        };
    </script>

    <?php $this->endBody() ?>
</body>


</html>
<?php $this->endPage() ?>
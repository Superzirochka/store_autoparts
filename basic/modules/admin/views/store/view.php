<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Store */

$this->title = $model->Name_shop;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Магазин'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="store-view">

    <div class="d-flex justify-content-between">
        <h2 class=" mt-3 "><strong><?= $this->title ?></strong></h2>
        <a class="btn mt-3 " onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Обновить'), ['update', 'id' => $model->Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), [
            //'delete', 
            'id' => $model->Id
        ], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы действительно хотите удалить ' . $this->title . ' ?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <!-- <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //   'Id',
                    'Name_shop',
                    'Description',
                    'Meta_title',
                    'Meta_description',
                    'Meta_keyword',
                    'Phone',
                    'Viber',
                    'Facebook_link',
                    'Work_time',
                    'Email:email',
                    'Adress',
                    'Date_add',
                    'Owner',
                    'Telegram_link',
                    'Google_map',
                    'Logo',
                    'logo_small',
                    'Id_lang',
                    'Description_ua',
                    'Meta_title_ua',
                    'Meta_description_ua',
                    'Meta_keyword_ua',
                    'Work_time_ua',
                    'Adress_ua',

                ],
            ]) ?> -->
    <div class="container">
        <div class="row">
            <div class="col-sm-6 ">
                <p class="text-light">Контактная информация </p>
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered col-sm-12'],
                    'model' => $model,
                    'attributes' => [
                        'Name_shop',
                        'Owner',
                        'Phone',
                        'Viber',
                        'Email:email',
                        'Facebook_link',
                        'Telegram_link',
                        'Date_add',



                    ],
                ]) ?>

            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-5 ">
                <p class="text-light">Информация о магазине</p>
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered col-sm-12'],
                    'model' => $model,
                    'attributes' => [
                        //'Google_map',                  

                        //  'Logo',
                        [
                            'attribute' => 'Logo',
                            'value' =>  '@web/img/' . $model->Logo,
                            'format' => ['image', ['class' => 'img adminBrend rounded mx-auto d-block']],

                        ],
                        // 'logo_small',
                        [
                            'attribute' => 'logo_small',
                            'value' =>  '@web/img/' . $model->logo_small,
                            'format' => ['image', ['class' => 'img adminBrend rounded mx-auto d-block']],

                        ],
                        //   'Id_lang',
                    ],
                ]) ?>
                <p class="text-light"> Карта </p>
                <iframe src="<?= $model->Google_map ?>" width="200" height="150" frameborder="0" style="border:0" allowfullscreen class="col-sm-12"></iframe>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered col-sm-12'],
                    'model' => $model,
                    'attributes' => [
                        //'Google_map',                  

                        'Info',

                    ],
                ]) ?>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#ru" role="tab" aria-controls="home" aria-selected="true"> О магазине (русский язык)</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#ua" role="tab" aria-controls="profile" aria-selected="false">Про магазин(українська мова)</a>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="ru" role="tabpanel" aria-labelledby="home-tab">
                    <p> О магазине (русский язык)</p>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //   'Id',                   
                            'Description:ntext',
                            'Meta_title:ntext',
                            'Meta_description:ntext',
                            'Meta_keyword:ntext',
                            'Work_time',
                            'Adress:html',
                        ],
                    ]) ?>

                </div>
                <div class="tab-pane fade" id="ua" role="tabpanel" aria-labelledby="profile-tab">
                    <p>Про магазин(українська мова)</p>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'Description_ua:ntext',
                            'Meta_title_ua:ntext',
                            'Meta_description_ua:ntext',
                            'Meta_keyword_ua:ntext',
                            'Work_time_ua',
                            'Adress_ua:html',
                        ],
                    ]) ?>


                </div>

            </div>
        </div>
    </div>


</div>
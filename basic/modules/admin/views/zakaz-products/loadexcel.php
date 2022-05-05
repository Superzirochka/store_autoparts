<?php

use mihaildev\ckeditor\CKEditor;


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\modules\admin\models\Supplier;
use app\modules\admin\models\BrandProd;
use app\modules\admin\models\Current;
use app\modules\admin\models\Discont;

$this->title = 'Таблица товаров загрузки';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ЗАказные товары'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$categoryName = Supplier::find()->select('Id, Supplier')->where(['Id' => $supplier])->one();

?>

<div class="row">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-sm-12">
            <h3> Поставщик: <?= $categoryName['Supplier'] ?> </h3>
            <h3> Картинка: <?= $link ?> </h3>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered text-white">
                <thead>
                    <tr>
                        <th>Наименование</th>
                        <th>Описание</th>
                        <th>Ссылка на изображение</th>
                        <th>Цена входная уе</th>
                        <th>Термин доставки</th>
                        <th>Доступное количество</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($data as $item) : ?>
                        <tr>
                            <td>
                                <?= $item['ProductName'] ?>
                            </td>
                            <td>
                                <?= $item['Description'] ?>
                            </td>
                            <td>
                                <?= $item['Img'] ?>
                            </td>
                            <td>
                                <?= $item['EntryPrice'] ?>
                            </td>
                            <td>
                                <?= $item['TermsDelive'] ?>
                            </td>
                            <td>
                                <?= $item['Count'] ?>
                            </td>

                        </tr>
                    <? endforeach ?>


                </tbody>
            </table>
        </div>
        <div class="col-sm-12 mt-5">
            <div class="d-flex justify-content-around">
                <a href="<?= yii\helpers\Url::to([
                                'loadexcel',
                                'add' => 'add',
                                //'data' => $data,
                                'link' => $link,
                                'fileName' => $fileName,
                                'supplier' => $supplier,
                            ]) ?>" class="btn btn-success w-25">
                    Загрузить в базу
                </a>

                <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
            </div>
        </div>

    </div>
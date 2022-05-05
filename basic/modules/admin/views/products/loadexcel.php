<?php

use mihaildev\ckeditor\CKEditor;


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\modules\admin\models\Category;
use app\modules\admin\models\BrandProd;
use app\modules\admin\models\Current;
use app\modules\admin\models\Discont;

$this->title = 'Таблица товаров загрузки';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Товары'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$categoryName = Category::find()->select('Id, Name')->where(['Id' => $Id_category])->one();
$brandName = BrandProd::find()->select('Id, Brand')->where(['Id' => $IdBrand])->one();


?>

<div class="row">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-sm-12">

            <h3> Категория: <?= $categoryName['Name'] ?> </h3>
            <h3> Бренд: <?= $brandName['Brand'] ?> </h3>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered text-white">
            <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Описание</th>
                    <!-- <th>Картинка 1</th>
                    <th>Картинка 2</th> -->
                    <th>Meta Title</th>
                    <th>Meta Описание</th>
                    <th>Meta keyword</th>
                    <th>Meta Title_ua</th>
                    <th>Meta Описание_ua</th>
                    <th>Meta keyword_ua</th>
                    <!-- <th>Бренд</th> -->
                    <!-- <th>Категория</th> -->
                    <th>Цена входная</th>
                    <th>Наценка</th>
                    <th>Валюта</th>
                    <th>Доступное количество</th>
                    <th>минимальный заказ</th>
                    <th>Единицы</th>

                </tr>
            </thead>
            <tbody>
                <? foreach($data as $item):?>
                <tr>
                    <td>
                        <?= $item['Name'] ?>
                    </td>
                    <td>
                        <?= $item['Description'] ?>
                    </td>
                    <!-- <td>
                        <?= $item['Img'] ?>
                    </td>
                    <td>
                        <?= $item['Img2'] ?>
                    </td> -->
                    <td>
                        <?= $item['MetaTitle'] ?>
                    </td>
                    <td>
                        <?= $item['MetaDescription'] ?>
                    </td>
                    <td>
                        <?= $item['MetaKeyword'] ?>
                    </td>
                    <td>
                        <?= $item['MetaTitle_ua'] ?>
                    </td>
                    <td>
                        <?= $item['MetaDescription_ua'] ?>
                    </td>
                    <td>
                        <?= $item['MetaKeyword_ua'] ?>
                    </td>

                    <!-- <td>
                        <?
                        $brand= BrandProd::find()->select(['Brand', 'Id'])->where(['Id'=> $item['IdBrand']])
                        //->orWhere(['Brand'=>$item['IdBrand']])
                        ->one();
                       // echo $brand->Brand;
                        ?>
                    </td> -->
                    <!-- <td>
                        <?//= $item['Id_category'] ?>
                    </td> -->
                    <td>
                        <?= $item['Price'] ?>
                    </td>
                    <td>
                        <?
                    $item['Markup']
                    //     $disc=Discont::find()->select(['Value_discont', 'Id'])->where(['Id'=>$item['Id_discont']])->one();
                    //     if(!$disc){
                    //         echo '0 %';
                    //     }
                    //    echo $disc->Value_discont .'%';
                         ?>
                    </td>
                    <td>
                        <?  $current=Current::find()->select(['Name', 'Id'])->where(['Id'=>$item['Id_current']])->one();
                        echo $current->Name
                          ?>
                    </td>
                    <td>
                        <?= $item['Availability'] ?>
                    </td>
                    <td>
                        <?= $item['MinQunt'] ?>
                    </td>
                    <td>
                        <?= $item['Units'] ?>
                    </td>
                </tr>
                <?endforeach?>


            </tbody>
        </table>
    </div>
    <div class="col-sm-12 mt-5">
        <div class="d-flex justify-content-around">
            <a href="<?= yii\helpers\Url::to([
                            'loadexcel',
                            'add' => 'add',
                            //'data' => $data,
                            'fileName' => $fileName,
                            'Id_category' => $Id_category,
                            'IdBrand' => $IdBrand
                        ]) ?>" class="btn btn-success w-25">
                Загрузить в базу
            </a>

            <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
        </div>
    </div>

</div>
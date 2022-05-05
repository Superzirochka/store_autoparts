<?

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Products;
use app\models\BrandProd;
use app\models\Category;

$brendProd = BrandProd::find()->select('Id, Brand, Img')->all();


?>

<div>
    <!-- <nav class="navbar navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#categorynav" aria-controls="categorynav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button><span class="text-dark">Категории</span>
    </nav> -->
    <!-- <div class="collapse" id="categorynav"> -->
    <div class="bg-light">
        <div id="accordion" class="col-sm-11 bg-light p-3">
            <? foreach ($parent as $par) : ?>
            <div class="list-group list-group-horizontal-sm list-group-item bg-light">
                <h6> <?= $par->Name ?></h6>

            </div>

            <div class="bg-light">
                <a href="<?= yii\helpers\Url::to(['autoshop/list', 'idCat' => $par->Id, 'nameCategory' =>  $par->Name]) ?>" class="list-group-item mycolor"><?= $par->Name ?> </a>
                <? foreach ($category as $cat) : ?>

                <? if ($par->Id == $cat->Id_parentCategory & $cat->Id != $par->Id) : ?>
                <a href="<?= yii\helpers\Url::to(['autoshop/list', 'idCat' => $cat->Id, 'nameCategory' =>  $cat->Name]) ?>" class="list-group-item mycolor"><?= $cat->Name ?></a>
                <? endif ?>


                <? endforeach ?>
            </div>
            <? endforeach ?>

        </div>
    </div>
    <!-- </div> -->

</div>
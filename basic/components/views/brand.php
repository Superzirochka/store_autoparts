<?

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Products;
use app\models\BrandProd;
use app\models\Category;

$brendProd = BrandProd::find()->select('Id, Brand, Img')->all();

?>




<div>
    <nav class="navbar navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#brandnav" aria-controls="brandnav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button><span class="text-dark">Бренд</span>
    </nav>
    <div class="collapse" id="brandnav">
        <div class="bg-light">
            <div class="col-sm-11 bg-light p-3">
                <? foreach ($brand as $br) : ?>
                    <div class="list-group list-group-horizontal-sm list-group-item bg-light">
                        <a href="<?= yii\helpers\Url::to(['autoshop/list', 'idBrand' => $br->Id, 'nameCategory' =>  $br->Brand]) ?>">
                            <h6><?= $br->Brand ?></h6>
                        </a>
                    </div>


                <? endforeach ?>

            </div>
        </div>
    </div>

</div>
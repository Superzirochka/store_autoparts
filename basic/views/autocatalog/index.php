<?php
/* @var $this yii\web\View */

use app\models\ManufacturerAuto;
use app\models\ModelAuto;
use app\models\Modification;
use app\models\Engine;
use app\models\ValueEngine;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\NodeAuto;

$autobrend = ManufacturerAuto::find()->select('Id, Marka, Img, link')->all();
$modif = Modification::find()->select(['IdModelAuto', 'IdEngine', 'IdValueEngine', 'Id'])->indexBy('Id')->all();
//getAllChildIds
?>
<div class="container my-shadow " id="content_box">
    <?if (!$marka || !$models ):?>
    <?if (!empty($marka)){
         $m=$marka;
        }?>
    <div class="row">
        <?//= app\components\AutoWidget::widget(); ?>
        <?= $this->render('/autoshop/_auto', [
            'model' => $model,
            'id' => $id
        ]) ?>
    </div>
    <?else:?>
    <div class="row">

        <div class="col-sm-3  mt-2">
            <!-- <span><?= $marka->Marka ?></span> -->
            <?
                $url = Yii::getAlias('@web') . '/img/' . $marka->Img;
                ?>
            <?= Html::img($url, ['alt' =>  $marka->Marka,  'width' => '60px', 'class' => 'ml-5']) ?>
        </div>
        <div class="col-sm-3  pt-3">
            <span class="text-center">Модель <i> <?= $models->FullName ?></i></span><br>
            <span>период выпуска <i><?= $models->constructioninterval ?></i></span>
        </div>

        <div class="col-sm-3  pt-3 align-items-center">
            <span>Модификация :</span>
            <p>
                <?$engine = Engine::findOne(['Id'=> $modification->IdEngine]);
            $valueEn= ValueEngine::findOne(['Id'=> $modification->IdValueEngine]);?>
                <i><?= $engine->Name . ' ' . $valueEn->Value ?></i>
            </p>
        </div>
        <div class="col-sm-3 ">
            <?
         $url = Yii::getAlias('@web') . '/img/marks/' . $models->Img;
        ?>
            <?= Html::img($url, ['alt' => 'Modification', 'width' => '160px', 'height' => '80px', 'class' => 'img']) ?>
        </div>
    </div>

    <div class="row mt-1 mb-2">
        <div class="accordion col-sm-12" id="accordionAuto">
            <?foreach($nodes as $node):?>
            <?if ($node->Id_parentNode == NULL):?>
            <div class="card">
                <div class="card-header" id="heading<?= $node->Id ?>">
                    <h5 class="mb-0">
                        <button class="btn btn-link w-100" type="button" data-toggle="collapse" data-target="#collapse<?= $node->Id ?>" aria-expanded="false" aria-controls="collapse<?= $node->Id ?>">
                            <div class="row">
                                <div class="col-sm-6"><?= Html::img('/img/node/' . $node->Img, ['alt' => $node->Node, 'width' => '120px', 'height' => '50px', 'class' => 'lazy loaded']) ?></div>
                                <div class="col-sm-6 mt-3">

                                    <?= $node->Node . '  ' ?>
                                    <span class="fa fa-chevron-right "> </span>
                                </div>
                            </div>
                        </button>
                    </h5>
                </div>

                <div id="collapse<?= $node->Id ?>" class="collapse" aria-labelledby="heading<?= $node->Id ?>" data-parent="#accordionAuto">
                    <div class="card-body">
                        <?$oemCodeChild='';
                        $childs= NodeAuto::getAllChildIds($node->Id);
                    //  echo($childs[0]);
                    if(empty($childs)){
                        foreach($oem as $i){
                            if($i->IdNode == $node->Id)
                           
                            $oemCodeChild.=$i->OEM.',';
                        }                        
                    }
                        foreach($childs as $c){
                            foreach($oem as $i){
                                if($i->IdNode == $c)
                             //   print_r($i->IdNode);
                                $oemCodeChild.=$i->OEM.',';
                            }
                        }
                        
                      // var_dump($childs);
                        ?>
                        <?if (empty($childs)):?>
                        <a href="<?= yii\helpers\Url::to([
                                        'search',
                                        //'autoshop/search',
                                        'search' => $oemCodeChild
                                    ]) ?>">
                            <?= $node->Node . '  ' ?>
                        </a>
                        <?else:?>

                        <a href="<?= yii\helpers\Url::to([
                                        'search',
                                        //'autoshop/search',
                                        'search' => $oemCodeChild
                                    ]) ?>">
                            <?= $node->Node . '  ' ?>
                        </a>
                        <ul>
                            <?foreach($childs as $child):?>

                            <li>

                                <?$c = NodeAuto::findOne($child);
                              $chis= NodeAuto::getAllChildIds($c->Id);
                            $oemCode='';
                            foreach($oem as $i){
                                if ($i->IdNode == $child){
                                    $oemCode.=$i->OEM.','; 
                                }
                            }
                            ?>
                                <a href="<?= yii\helpers\Url::to([
                                                'search',
                                                //'autoshop/search',
                                                'search' => $oemCode
                                            ]) ?>">
                                    <?= $c->Node ?>
                                </a>


                            </li>
                            <?endforeach?>
                        </ul>
                        <?endif?>
                    </div>
                </div>
            </div>
            <?endif?>
            <?endforeach?>

        </div>
    </div>
    <?endif?>


    <div class="row fabric">
        <!--карусель марок-->
        <?= app\components\AutobrendWidget::widget(); ?>

    </div>
</div>
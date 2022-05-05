<?php

namespace app\components;


use yii\base\Widget;
use app\models\BrandProd;



class BrandWidget extends Widget
{
    public function init()
    {
    }



    public function run()
    {
        $brand = BrandProd::find()->select('Id, Brand, Img')->all();



        return $this->render('brand', ['brand' => $brand]);
    }
}

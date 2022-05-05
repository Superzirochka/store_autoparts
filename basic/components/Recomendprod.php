<?php

namespace app\components;

use yii\base\Widget;
use app\models\Products;

class Recomendprod extends Widget
{
    public function run()
    {
        $recItem = Products::find()->select(' Id, Name, Description, Img, Img2, MetaDescription, MetaTitle, MetaKeyword, IdBrand, Id_lang, Id_category, Price, Id_discont, Availability, Id_current, MinQunt, DateAdd')->where(['Status' => 10])->orderBy('DateAdd DESC')->limit(10)->all();
        return $this->render('recomendprod',  compact('recItem'));
    }
}

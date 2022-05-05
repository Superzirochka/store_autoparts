<?php

namespace app\components;

use yii;
use yii\base\Widget;
use app\models\Category;



class CategoryWidget extends Widget
{
    public function init()
    {
    }



    public function run()
    {
        $parent =  Yii::$app->cache->get('parent');
        $category = Yii::$app->cache->get('category');
        if (!$category) {

            $category = Category::find()->select('Id, Id_lang
, Name, Description,  MetaTitle, MetaDescription, MetaKeyword,  Id_parentCategory, Img')->all();
            Yii::$app->cache->set('category', $category, 3600);
        }

        if (!$parent) {
            $parent = [];
            foreach ($category as $cat) {
                if ($cat->Id_parentCategory == null)
                    array_push($parent, $cat);
            }
            Yii::$app->cache->set('parent', $parent, 3600);
        }




        return $this->render('category', ['category' => $category, 'parent' => $parent]);
    }
}

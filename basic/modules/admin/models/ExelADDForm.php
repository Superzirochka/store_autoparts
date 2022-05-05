<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii;

/** 
 * @property Category $category;
 */

class ExelADDForm extends Model
{
    public $file;
    public $category;
    public $brand;

    public function rules()
    {
        return [

            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xls, csv, xlsx'],
            ['category', 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['Id_category' => 'Id']],
            [['brand'], 'exist', 'skipOnError' => true, 'targetClass' => BrandProd::class, 'targetAttribute' => ['IdBrand' => 'Id']],

        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Загрузите файл',
            'category' => 'Выберите категорию',
            'brand' => Yii::t('app', 'Бренд'),
        ];
    }
}

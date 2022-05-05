<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii;

/** 
 * @property Supplier $category;
 */

class ExelZakazADDForm extends Model
{
    public $file;
    public $supplier;
    public $link;


    public function rules()
    {
        return [

            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xls, csv, xlsx'],
            ['supplier', 'exist', 'skipOnError' => true, 'targetClass' => Supplier::class, 'targetAttribute' => ['Supplier' => 'Id']],
            [['link'], 'string', 'skipOnError' => false],

        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Загрузите файл',
            'supplier' => 'Выберите поставщика',
            'link' => 'Ссылка на картинку'
        ];
    }
}

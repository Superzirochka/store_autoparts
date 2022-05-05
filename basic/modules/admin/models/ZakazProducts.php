<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "zakaz_products".
 *
 * @property int $Id
 * @property string $Supplier поставщик
 * @property string $Brand
 * @property string $ProductName
 * @property string $Description
 * @property float $EntryPrice входная цена
 * @property int $Markup наценка
 * @property float $Price цена
 * @property string $TermsDelive сроки поставки
 * @property string|null $Img
 * @property int $Count
 */
class ZakazProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zakaz_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Supplier', 'Brand', 'ProductName', 'Description', 'EntryPrice', 'Markup', 'Price', 'TermsDelive', 'Count'], 'required'],
            [['EntryPrice', 'Price'], 'number'],
            [['Supplier', 'Markup', 'Count'], 'integer'],
            [['Brand'], 'string', 'max' => 100],
            [['ProductName'], 'string', 'max' => 250],
            [['Description', 'Img'], 'string', 'max' => 500],
            [['TermsDelive'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Supplier' => Yii::t('app', 'Поставщик'),
            'Brand' => Yii::t('app', 'Бренд'),
            'ProductName' => Yii::t('app', 'Наименованеи'),
            'Description' => Yii::t('app', 'Описание'),
            'EntryPrice' => Yii::t('app', 'Входная цена, y.e'),
            'Markup' => Yii::t('app', 'Наценка'),
            'Price' => Yii::t('app', 'Цена выходная, грн'),
            'TermsDelive' => Yii::t('app', 'Термин доставки'),
            'Img' => Yii::t('app', 'Изображение'),
            'Count' => Yii::t('app', 'Колличество'),
        ];
    }

    
}

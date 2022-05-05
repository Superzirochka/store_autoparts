<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brand_prod".
 *
 * @property int $Id
 * @property string $Brand
 * @property string $Img
 *
 * @property Products[] $products
 */
class BrandProd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand_prod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Brand', 'Img'], 'required'],
            [['Brand'], 'string', 'max' => 100],
            [['Img'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Brand' => 'Brand',
            'Img' => 'Img',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['IdBrand' => 'Id']);
    }
}

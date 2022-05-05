<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_img".
 *
 * @property int $Id
 * @property int $IdProduct
 * @property string $Img
 *
 * @property Products $idProduct
 */
class ProductImg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_img';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'IdProduct', 'Img'], 'required'],
            [['Id', 'IdProduct'], 'integer'],
            [['Img'], 'string', 'max' => 500],
            [['Id'], 'unique'],
            [['IdProduct'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['IdProduct' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'IdProduct' => 'Id Product',
            'Img' => 'Img',
        ];
    }

    /**
     * Gets query for [[IdProduct]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduct()
    {
        return $this->hasOne(Products::class, ['Id' => 'IdProduct']);
    }
}

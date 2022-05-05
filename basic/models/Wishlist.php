<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wishlist".
 *
 * @property int $Id
 * @property int $IdCustomer
 * @property int $IdProduct
 * @property string $Name
 * @property float $Price
 * @property int $MinQunt
 * @property string $DateAdd
 *
 * @property Customers $idCustomer
 * @property Products $idProduct
 */
class Wishlist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wishlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdCustomer', 'IdProduct', 'Name', 'Price', 'MinQunt', 'DateAdd'], 'required'],
            [['IdCustomer', 'IdProduct', 'MinQunt'], 'integer'],
            [['Price'], 'number'],
            [['DateAdd'], 'safe'],
            [['Name'], 'string', 'max' => 250],
            [['IdCustomer'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::class, 'targetAttribute' => ['IdCustomer' => 'Id']],
            [['IdProduct'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['IdProduct' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'IdCustomer' => Yii::t('app', 'Id покупателя'),
            'IdProduct' => Yii::t('app', 'Id товара'),
            'Name' => Yii::t('app', 'Наименование'),
            'Price' => Yii::t('app', 'Цена'),
            'MinQunt' => Yii::t('app', 'Минимальный заказ'),
            'DateAdd' => Yii::t('app', 'Дата добавления'),
        ];
    }

    /**
     * Gets query for [[IdCustomer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCustomer()
    {
        return $this->hasOne(Customers::class, ['Id' => 'IdCustomer']);
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

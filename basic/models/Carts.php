<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carts".
 *
 * @property int $Id
 * @property int $IdProduct
 * @property int $IdCustomer
 * @property string|null $Name
 * @property float $Price
 * @property string $DateAdd
 * @property int $Quanty
 *
 * @property Customers $idCustomer
 * @property Products $idProduct
 */
class Carts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdProduct', 'IdCustomer', 'Price', 'DateAdd'], 'required'],
            [['IdProduct', 'IdCustomer', 'Quanty'], 'integer'],
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
            'IdProduct' => Yii::t('app', 'Id Товара'),
            'IdCustomer' => Yii::t('app', 'Id Покупателя'),
            'Name' => Yii::t('app', 'Наименование'),
            'Price' => Yii::t('app', 'Цена'),
            'DateAdd' => Yii::t('app', 'Дата добавления'),
            'Quanty' => Yii::t('app', 'Количество'),
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

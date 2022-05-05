<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "carts".
 *
 * @property int $Id
 * @property int $IdProduct
 * @property int $IdCustomer
 * @property int|null $IdSession
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
            [['IdProduct', 'IdCustomer', 'DateAdd'], 'required'],
            [['IdProduct', 'IdCustomer', 'IdSession', 'Quanty'], 'integer'],
            [['DateAdd'], 'safe'],
            [['IdCustomer'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::className(), 'targetAttribute' => ['IdCustomer' => 'Id']],
            [['IdProduct'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['IdProduct' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'IdProduct' => Yii::t('app', 'Id Product'),
            'IdCustomer' => Yii::t('app', 'Id Customer'),
            'IdSession' => Yii::t('app', 'Id Session'),
            'DateAdd' => Yii::t('app', 'Date Add'),
            'Quanty' => Yii::t('app', 'Quanty'),
        ];
    }

    /**
     * Gets query for [[IdCustomer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCustomer()
    {
        return $this->hasOne(Customers::className(), ['Id' => 'IdCustomer']);
    }

    /**
     * Gets query for [[IdProduct]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduct()
    {
        return $this->hasOne(Products::className(), ['Id' => 'IdProduct']);
    }
}

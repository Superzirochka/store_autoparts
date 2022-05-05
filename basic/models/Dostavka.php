<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dostavka".
 *
 * @property int $Id
 * @property string $Name
 *
 * @property OrdersShop[] $ordersShops
 */
class Dostavka extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dostavka';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['Name'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Name' => 'Name',
        ];
    }

    /**
     * Gets query for [[OrdersShops]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersShops()
    {
        return $this->hasMany(OrdersShop::className(), ['IdDostavka' => 'Id']);
    }
}

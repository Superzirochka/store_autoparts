<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "oplata".
 *
 * @property int $Id
 * @property string $Name
 *
 * @property OrdersShop[] $ordersShops
 */
class Oplata extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oplata';
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
            'Id' => Yii::t('app', 'ID'),
            'Name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Gets query for [[OrdersShops]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersShops()
    {
        return $this->hasMany(OrdersShop::class, ['IdOplata' => 'Id']);
    }
}

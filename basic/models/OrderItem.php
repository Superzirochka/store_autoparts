<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property int $Id
 * @property int $IdOrder
 * @property int $IdProduct
 * @property string $Name
 * @property float $Price
 * @property int $Quanty
 * @property float $Cost
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdOrder', 'IdProduct', 'Name', 'Price', 'Quanty', 'Cost'], 'required'],
            [['IdOrder', 'IdProduct', 'Quanty'], 'integer'],
            [['Price', 'Cost'], 'number'],
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
            'IdOrder' => 'Id Order',
            'IdProduct' => 'Id Product',
            'Name' => 'Name',
            'Price' => 'Price',
            'Quanty' => 'Quanty',
            'Cost' => 'Cost',
        ];
    }
}

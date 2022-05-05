<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property int $Id
 * @property string $IdOrder
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
            [['IdProduct', 'Quanty'], 'integer'],
            [['Price', 'Cost'], 'number'],
            [['IdOrder', 'Name'], 'string', 'max' => 250],
            [['Availability', '	Supplier'], 'string', 'max' => 150],
            [['Brand'], 'string', 'max' => 100]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'IdOrder' => Yii::t('app', 'Id Order'),
            'IdProduct' => Yii::t('app', 'Id Product'),
            'Name' => Yii::t('app', 'Наименование'),
            'Price' => Yii::t('app', 'Цена'),
            'Quanty' => Yii::t('app', 'Количество'),
            'Cost' => Yii::t('app', 'Сумма'),
            'Availability' => Yii::t('app', 'наличие'),
            'Supplier' => Yii::t('app', 'поставщик'),
            'Brand' => Yii::t('app', 'Бранд'),
        ];
    }

    public function getOrder()
    {
        // связь таблицы БД `order_item` с таблицей `order`
        return $this->hasOne(OrdersShop::class, ['Id' => 'IdOrder']);
    }
}

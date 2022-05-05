<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "orders_shop".
 *
 * @property int $Id
 * @property string $OrderNumber
 * @property int $IdUser
 * @property string $Name
 * @property string $LastName
 * @property string $Email
 * @property string $Phone
 * @property string $City
 * @property int $IdDostavka
 * @property string|null $Comment
 * @property float $Amount
 * @property string $Status
 * @property string $DateAdd
 * @property string $DateUpdate
 * @property int $IdOplata
 * @property int $Mailing
 * @property string|null $Adress
 *
 * @property Dostavka $idDostavka
 * @property Oplata $idOplata
 */
class OrdersShop extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    // при обновлении существующей записи присвоить атрибуту
                    // updated значение метки времени UNIX
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['DateUpdate'],
                ],
                // если вместо метки времени UNIX используется DATETIME
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders_shop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OrderNumber', 'Name', 'LastName', 'Email', 'Phone', 'City', 'IdDostavka', 'Amount', 'DateAdd', 'IdOplata'], 'required'],
            [['IdUser', 'IdDostavka', 'IdOplata', 'Mailing'], 'integer'],
            [['Amount'], 'number'],
            [['DateAdd', 'DateUpdate'], 'safe'],
            [['OrderNumber', 'LastName', 'Email'], 'string', 'max' => 250],
            [['Name', 'Status'], 'string', 'max' => 100],
            [['Phone'], 'string', 'max' => 50],
            [['City'], 'string', 'max' => 150],
            [['Comment', 'Adress'], 'string', 'max' => 1000],
            [['OrderNumber'], 'unique'],
            [['IdDostavka'], 'exist', 'skipOnError' => true, 'targetClass' => Dostavka::class, 'targetAttribute' => ['IdDostavka' => 'Id']],
            [['IdOplata'], 'exist', 'skipOnError' => true, 'targetClass' => Oplata::class, 'targetAttribute' => ['IdOplata' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'OrderNumber' => Yii::t('app', 'Номер заказа'),
            'IdUser' => Yii::t('app', 'Id покупателя'),
            'Name' => Yii::t('app', 'Имя'),
            'LastName' => Yii::t('app', 'Фамилия'),
            'Email' => Yii::t('app', 'Email'),
            'Phone' => Yii::t('app', 'Телефон'),
            'City' => Yii::t('app', 'Город'),
            'IdDostavka' => Yii::t('app', 'Способ доставки'),
            'Comment' => Yii::t('app', 'Комментарий'),
            'Amount' => Yii::t('app', 'Сумма'),
            'Status' => Yii::t('app', 'Статус'),
            'DateAdd' => Yii::t('app', 'Дата добавления'),
            'DateUpdate' => Yii::t('app', 'Дата обновления'),
            'IdOplata' => Yii::t('app', 'Способ оплаты'),
            'Mailing' => Yii::t('app', 'Подписка'),
            'Adress' => Yii::t('app', 'Адрес'),
        ];
    }

    /**
     * Gets query for [[IdDostavka]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDostavka()
    {
        return $this->hasOne(Dostavka::class, ['Id' => 'IdDostavka']);
    }

    /**
     * Gets query for [[IdOplata]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOplata()
    {
        return $this->hasOne(Oplata::class, ['Id' => 'IdOplata']);
    }

    public function getItems()
    {
        // связь таблицы БД `order` с таблицей `order_item`
        return $this->hasMany(OrderItem::class, ['IdOrder' => 'OrderNumber']);
    }
    public function afterDelete()
    {
        parent::afterDelete();
        OrderItem::deleteAll(['IdOrder' => $this->OrderNumber]);
    }
}

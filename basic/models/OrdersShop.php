<?php

namespace app\models;

use Yii;

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
 * @property int $IdOplata
 * @property int $Mailing
 *
 * @property Dostavka $idDostavka
 * @property Oplata $idOplata
 */
class OrdersShop extends \yii\db\ActiveRecord
{
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
            [['DateAdd'], 'safe'],
            [['OrderNumber', 'LastName', 'Email'], 'string', 'max' => 250],
            [['Name', 'Status'], 'string', 'max' => 100],
            [['Phone'], 'string', 'max' => 50],
            [['City'], 'string', 'max' => 150],
            [['Comment'], 'string', 'max' => 1000],
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
            'Id' => 'ID',
            'OrderNumber' => 'Order Number',
            'IdUser' => 'Id User',
            'Name' => 'Name',
            'LastName' => 'Last Name',
            'Email' => 'Email',
            'Phone' => 'Phone',
            'City' => 'City',
            'IdDostavka' => 'Id Dostavka',
            'Comment' => 'Comment',
            'Amount' => 'Amount',
            'Status' => 'Status',
            'DateAdd' => 'Date Add',
            'IdOplata' => 'Id Oplata',
            'Mailing' => 'Mailing',
        ];
    }

    /**
     * Gets query for [[IdDostavka]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdDostavka()
    {
        return $this->hasOne(Dostavka::class, ['Id' => 'IdDostavka']);
    }

    /**
     * Gets query for [[IdOplata]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdOplata()
    {
        return $this->hasOne(Oplata::class, ['Id' => 'IdOplata']);
    }
}

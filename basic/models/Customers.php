<?php

namespace app\models;

use yii\web\User;

use Yii;
use yii\web\IdentityInterface;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * This is the model class for table "customers".
 *
 * @property int $Id
 * @property string $FName
 * @property string $LName
 * @property string $Email
 * @property string $Phone
 * @property string $Password
 * @property string $News
 * @property string $Adres
 * @property int $IdGruop
 * @property string $hash
 *
 * @property Carts[] $carts
 * @property Reviews[] $reviews
 * @property Wishlist[] $wishlists
 */
class Customers extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 10;
    const STATUS_DELETE = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FName', 'LName', 'Email', 'Phone', 'Password', 'News', 'hash'], 'required'],
            [['IdGruop'], 'integer'],
            [['FName', 'LName'], 'string', 'max' => 200],
            [['Email', 'hash', 'password_reset_token'], 'string', 'max' => 250],
            [['Phone'], 'string', 'max' => 15],
            [['Password'], 'string', 'max' => 150],
            [['News'], 'string', 'max' => 5],
            [['City'], 'string', 'max' => 250],
            [['Adres'], 'string', 'max' => 1000],
            [['Status'], 'integer', 'max' => 20],
            ['Status', 'default', 'value' => self::STATUS_ACTIVE],
            [['DateRegistration'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Login' => Yii::t('app', 'Логин'),
            'FName' => Yii::t('app', 'Имя'),
            'LName' => Yii::t('app', 'Фамилия'),
            'Email' => Yii::t('app', 'Email'),
            'Phone' => Yii::t('app', 'Телефон'),
            'Password' => Yii::t('app', 'Password'),
            'News' => Yii::t('app', 'Подписка на новости'),
            'City' => Yii::t('app', 'Город доставки'),
            'Adres' => Yii::t('app', 'Адрес доставки'),
            'IdGruop' => Yii::t('app', 'Категория пользователя'),
            'hash' => Yii::t('app', 'Hash'),
            'Status' => Yii::t('app', 'Статус'),
            'DateRegistration' => Yii::t('app', 'Дата регистрации'),
            'password_reset_token' => Yii::t('app', 'Дата регистрации'),
        ];
    }


    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Carts::class, ['IdCustomer' => 'Id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['Id_Costome' => 'Id']);
    }

    /**
     * Gets query for [[Wishlists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWishlists()
    {
        return $this->hasMany(Wishlist::class, ['IdCustomer' => 'Id']);
    }

   
}

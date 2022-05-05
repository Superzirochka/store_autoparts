<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $Id
 * @property string $Login
 * @property string $FName
 * @property string $LName
 * @property string $Email
 * @property string $Phone
 * @property string $Password
 * @property string $News
 * @property string $City
 * @property string $Adres
 * @property int|null $IdGruop
 * @property string $hash
 * @property string $password_reset_token
 * @property int $Status
 * @property string|null $DateRegistration
 *
 * @property Carts[] $carts
 * @property Reviews[] $reviews
 * @property Wishlist[] $wishlists
 */
class Customers extends \yii\db\ActiveRecord
{
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
            [['Login', 'FName', 'LName', 'Email', 'Phone', 'Password', 'hash', 'password_reset_token'], 'required'],
            [['IdGruop', 'Status'], 'integer'],
            [['DateRegistration'], 'safe'],
            [['Login', 'Email', 'City', 'hash', 'password_reset_token'], 'string', 'max' => 250],
            [['FName', 'LName'], 'string', 'max' => 200],
            [['Phone'], 'string', 'max' => 15],
            [['Password', 'Adres'], 'string', 'max' => 1000],
            [['News'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Login' => Yii::t('app', 'Login'),
            'FName' => Yii::t('app', 'Имя'),
            'LName' => Yii::t('app', 'Фамилия'),
            'Email' => Yii::t('app', 'Электронная почта'),
            'Phone' => Yii::t('app', 'Телефон'),
            'Password' => Yii::t('app', 'Password'),
            'News' => Yii::t('app', 'Подписка на новости'),
            'City' => Yii::t('app', 'Город'),
            'Adres' => Yii::t('app', 'Адрес'),
            'IdGruop' => Yii::t('app', 'Группа покупателей'),
            'hash' => Yii::t('app', 'Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'Status' => Yii::t('app', 'Статус'),
            'DateRegistration' => Yii::t('app', 'Дата регистрации'),
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

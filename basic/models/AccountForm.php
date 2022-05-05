<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class AccountForm extends Model
{
    public $nameuser;
    public $sername;
    public $email;
    public $phone;
    public $password;
    public $news;
    public $city;
    public $adres;
    public $login;

    public function rules()
    {
        return [
            [['login', 'nameuser', 'sername', 'email', 'phone', 'password', 'news'], 'required', 'message' => 'Поля не могут быть пустыми. '],
            [['nameuser', 'sername'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 250],
            [['phone'], 'string', 'max' => 15],
            [['password'], 'string', 'max' => 150],
            [['news'], 'string', 'max' => 5],
            [['city'], 'string', 'max' => 250],
            [['adres'], 'string', 'max' => 1000],

        ];
    }

    public function attributeLabels()
    {
        return [

            'login' => Yii::t('app', 'Логин'),
            'nameuser' => Yii::t('app', 'Имя'),
            'sername' => Yii::t('app', 'Фамилия'),
            'email' => Yii::t('app', 'Почта'),
            'phone' => Yii::t('app', 'Телефон'),
            'password' => Yii::t('app', 'Пароль'),
            'news' => Yii::t('app', 'Подписка на новости'),
            'city' => Yii::t('app', 'Город'),
            'adres' => Yii::t('app', 'Адрес доставки'),

        ];
    }
}

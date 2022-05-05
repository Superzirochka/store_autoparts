<?php

namespace app\models;

use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    // public $id;
    // public $username;
    // public $password;
    // public $authKey;
    // public $accessToken;
    const STATUS_ACTIVE = 10;
    const STATUS_DELETE = 0;

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
            'password_reset_token' => Yii::t('app', ' password_reset_token'),
        ];
    }


    // private static $users = [
    //     '100' => [
    //         'id' => '100',
    //         'username' => 'admin',
    //         'password' => 'admin',
    //         'authKey' => 'test100key',
    //         'accessToken' => '100-token',
    //         'email' => 'admin@site.com',
    //     ],
    //     '101' => [
    //         'id' => '101',
    //         'username' => 'demo',
    //         'password' => 'demo',
    //         'authKey' => 'test101key',
    //         'accessToken' => '101-token',
    //         'email' => 'demo@site.com',
    //     ],
    // ];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['hash' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($login)
    {

        return static::findOne(['Login' => $login]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['Email' => $email, 'Status' => self::STATUS_ACTIVE]);
        // return static::findOne(['Email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->Password);
    }
    //сброс пароля

    public static function findByPasswordResetToken($token)
    {

        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'Status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {

        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    // public function setPassword()
    // {
    //     \Yii::$app->security->generatePasswordHash($model->password)
    // }
    public function removePasswordResetToken()
    {
        $this->password_reset_token = \Yii::$app->security->generatePasswordHash($this->Password);

        //null;
    }
}

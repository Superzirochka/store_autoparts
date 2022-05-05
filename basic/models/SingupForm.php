<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Customers;

/**
 * LoginForm is the model behind the login form.
 *
 * @property Customers|null $user This property is read-only.
 *
 */
class SingupForm extends Model
{
    public $login;
    public $fname;
    public $lname;
    public $email;
    public $phone;
    public $password;
    public $news = true;
    public $city;
    public $adres;
    public $rememberMe = true;

    private $_customer = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['login', 'fname', 'lname', 'email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['login', 'unique', 'targetClass' => User::class,  'message' => 'Этот логин уже занят'],
            ['rememberMe', 'boolean'],
            ['news', 'boolean'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class,  'message' => 'Этот email уже занят'],
            [['phone', 'city', 'adres'], 'string']
            // password is validated by validatePassword()
            // ['password', 'password'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'fname' => 'Имя',
            'lname' => 'Фамилия',
            'email' => 'Электронная почта',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'city' => 'Город доставки',
            'adres' => 'Адрес доставки',
            'rememberMe' => 'Запомни меня',
            'news' => 'Подписаться на новости',
        ];
    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $customer = $this->getUser();

            if (!$customer || !$customer->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверно введен пароль или имя пользователя.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    // public function login()
    // {
    //     if ($this->validate()) {
    //         return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    //     }
    //     return false;
    // }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_customer === false) {
            $this->_customer = User::findByUsername($this->customername);
        }

        return $this->_customer;
    }
}

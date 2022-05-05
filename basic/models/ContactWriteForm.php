<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactWriteForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // удалить пробелы для всех полей формы
            [['name', 'email', 'subject', 'body'], 'trim'],
            ['name', 'required', 'message' => 'Поле «Ваше имя» обязательно для заполнения'],
            // поле email обязательно для заполнения
            ['email', 'required', 'message' => 'Поле «Ваш email» обязательно для заполнения'],
            // поле email должно быть корректным адресом почты
            ['email', 'email', 'message' => 'Поле «Ваш email» должно быть адресом почты'],
            // поле body обязательно для заполнения
            ['body', 'required', 'message' => 'Поле «Сообщение» обязательно для заполнения'],
            // name, email, subject and body are required
            ['subject', 'required', 'message' => 'Поле «Тема сообщения» обязательно для заполнения'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ваше Имя',
            'email' => 'Электронная почта',
            'body' => 'Оставьте свое сообщение',
            'subject' => 'Тема сообщения',

        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
}

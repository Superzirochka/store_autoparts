<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AutoForm extends Model
{
    public $marka;
    public $model;
    public $modification;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // удалить пробелы для всех полей формы
            [['marka', 'model', 'modification'], 'required'],
            [['marka', 'model', 'modification'], 'integer'],

        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'marka' => Yii::t('app', 'Выберите марку '),
            'model' =>  Yii::t('app', 'Выберите модель'),
            'modification' =>  Yii::t('app', 'Выберите модификацию'),


        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
}

<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "zakaz".
 *
 * @property int $Id
 * @property string $MarkaAuto
 * @property string $ModelAuto
 * @property string $YearCon
 * @property string $ValueEngine
 * @property string|null $VIN
 * @property string $Description
 * @property string $FIO
 * @property string $Email
 * @property string $Phone
 * @property string $DateAdd
 * @property string $Status
 */
class Zakaz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zakaz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MarkaAuto', 'ModelAuto', 'YearCon', 'ValueEngine', 'Description', 'FIO', 'Email', 'Phone', 'DateAdd'], 'required'],
            [['DateAdd'], 'safe'],
            [['MarkaAuto'], 'string', 'max' => 100],
            [['ModelAuto', 'ValueEngine', 'VIN', 'Email', 'Phone'], 'string', 'max' => 250],
            [['YearCon', 'FIO'], 'string', 'max' => 500],
            [['Description'], 'string', 'max' => 1000],
            [['Status'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'MarkaAuto' => Yii::t('app', 'Марка автомобиля'),
            'ModelAuto' => Yii::t('app', 'Модель автомобиля'),
            'YearCon' => Yii::t('app', 'Год выпуска'),
            'ValueEngine' => Yii::t('app', 'Объем двигателя'),
            'VIN' => Yii::t('app', 'Vin код'),
            'Description' => Yii::t('app', 'Содержание заказа'),
            'FIO' => Yii::t('app', 'Данные пользователя'),
            'Email' => Yii::t('app', 'Email'),
            'Phone' => Yii::t('app', 'Телефон'),
            'DateAdd' => Yii::t('app', 'Дата запроса'),
            'Status' => Yii::t('app', 'Статус'),
        ];
    }
}

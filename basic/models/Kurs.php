<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kurs".
 *
 * @property int $Id
 * @property float $Current_kurs
 */
class Kurs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kurs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'Current_kurs'], 'required'],
            [['Id'], 'integer'],
            [['Current_kurs'], 'number'],
            [['Id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Current_kurs' => Yii::t('app', 'Current Kurs'),
        ];
    }
}

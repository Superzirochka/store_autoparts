<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "analog".
 *
 * @property int $Marka
 * @property string $OEM
 * @property string $Analog
 * @property string $Brand
 */
class Analog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Marka', 'OEM', 'Analog', 'Brand'], 'required'],
            [['Marka'], 'integer'],
            [['OEM', 'Analog', 'Brand'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Marka' => Yii::t('app', 'Марка'),
            'OEM' => Yii::t('app', 'OEM'),
            'Analog' => Yii::t('app', 'Аналог'),
            'Brand' => Yii::t('app', 'Производитель'),
        ];
    }
}

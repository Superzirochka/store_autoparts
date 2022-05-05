<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "value_engine".
 *
 * @property int $Id
 * @property float $Value
 *
 * @property Auto[] $autos
 * @property Modification[] $modifications
 */
class ValueEngine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'value_engine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Value'], 'required'],
            [['Value'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Value' => 'Value',
        ];
    }

    /**
     * Gets query for [[Autos]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getAutos()
    // {
    //     return $this->hasMany(Auto::className(), ['Id_valueEngine' => 'Id']);
    // }

    /**
     * Gets query for [[Modifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModifications()
    {
        return $this->hasMany(Modification::class, ['IdValueEngine' => 'Id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "engine".
 *
 * @property int $Id
 * @property string $Name
 * @property int $Id_lang
 *
 * @property Auto[] $autos
 * @property Lang $lang
 * @property Modification[] $modifications
 */
class Engine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'engine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name', 'Id_lang'], 'required'],
            [['Id_lang'], 'integer'],
            [['Name'], 'string', 'max' => 20],
            [['Id_lang'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::class, 'targetAttribute' => ['Id_lang' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Name' => 'Name',
            'Id_lang' => 'Id Lang',
        ];
    }

    /**
     * Gets query for [[Autos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutos()
    {
        return $this->hasMany(Auto::className(), ['Id_engine' => 'Id']);
    }

    /**
     * Gets query for [[Lang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::class, ['Id' => 'Id_lang']);
    }

    /**
     * Gets query for [[Modifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModifications()
    {
        return $this->hasMany(Modification::className(), ['IdEngine' => 'Id']);
    }
}

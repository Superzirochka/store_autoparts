<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "model_auto".
 *
 * @property int $Id
 * @property int $IdManufacturer
 * @property string $ModelName
 * @property string $FullName
 * @property string $constructioninterval
 *
 * @property Auto[] $autos
 * @property ManufacturerAuto $idManufacturer
 * @property Modification[] $modifications
 */
class ModelAuto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'model_auto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdManufacturer', 'ModelName', 'FullName', 'constructioninterval'], 'required'],
            [['IdManufacturer'], 'integer'],
            [['ModelName', 'Img'], 'string', 'max' => 500],
            [['FullName', 'constructioninterval'], 'string', 'max' => 500],
            [['IdManufacturer'], 'exist', 'skipOnError' => true, 'targetClass' => ManufacturerAuto::class, 'targetAttribute' => ['IdManufacturer' => 'Id']],
            ['Img', 'image', 'extensions' => 'png, jpg, jpeg, gif'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'IdManufacturer' => Yii::t('app', 'Марка'),
            'ModelName' => Yii::t('app', 'Модель'),
            'FullName' => Yii::t('app', 'Полное название'),
            'constructioninterval' => Yii::t('app', 'Года выпуска'),
            'Img' => Yii::t('app', 'Вид'),
        ];
    }



    /**
     * Gets query for [[IdManufacturer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdManufacturer()
    {
        return $this->hasOne(ManufacturerAuto::class, ['Id' => 'IdManufacturer']);
    }

    /**
     * Gets query for [[Modifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModifications()
    {
        return $this->hasMany(Modification::class, ['IdModelAuto' => 'Id']);
    }
}

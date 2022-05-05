<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "manufacturer_auto".
 *
 * @property int $Id
 * @property string $Marka
 * @property string $Img
 * @property string $Link
 *
 * @property ModelAuto[] $modelAutos
 */
class ManufacturerAuto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manufacturer_auto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Marka', 'Img', 'Link'], 'required'],
            [['Marka'], 'string', 'max' => 50],
            [['Img', 'Link'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Marka' => 'Marka',
            'Img' => 'Img',
            'Link' => 'Link',
        ];
    }

    /**
     * Gets query for [[ModelAutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModelAutos()
    {
        return $this->hasMany(ModelAuto::className(), ['IdManufacturer' => 'Id']);
    }
    // public static function getActiveMarka()
    // {
    //     return ArrayHelper::map(self::find()->where(['status' => self::STATUS_ACTIVE])->orderBy('Marka')->all(), 'Id', 'Marka');
    // }
}

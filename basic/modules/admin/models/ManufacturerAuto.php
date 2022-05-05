<?php

namespace app\modules\admin\models;

use Yii;

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

    public $imageFile;

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
            ['Img', 'image', 'extensions' => 'png, jpg, jpeg, gif'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Marka' => Yii::t('app', 'Марка'),
            'Img' => Yii::t('app', 'Эмблема'),
            'Link' => Yii::t('app', 'Ссылка'),
            'imageFile' => Yii::t('app', 'Загрузить'),
        ];
    }

    /**
     * Gets query for [[ModelAutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModelAutos()
    {
        return $this->hasMany(ModelAuto::class, ['IdManufacturer' => 'Id']);
    }
}

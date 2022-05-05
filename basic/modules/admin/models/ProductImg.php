<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "product_img".
 *
 * @property int $Id
 * @property int $IdProduct
 * @property string $Img
 *
 * @property Products $idProduct
 */
class ProductImg extends \yii\db\ActiveRecord
{
    public $fileupload;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_img';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdProduct', 'Img'], 'required'],
            [['Id', 'IdProduct'], 'integer'],
            ['Img', 'image', 'extensions' => 'png, jpg, gif'],
            // [['Img'], 'string', 'max' => 500],
            [['Id'], 'unique'],
            [['IdProduct'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['IdProduct' => 'Id']],
            [['fileupload'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'IdProduct' => Yii::t('app', 'Наименование товара'),
            'Img' => Yii::t('app', 'Картинка'),
            'fileupload' => 'Загрузить',
        ];
    }

    /**
     * Gets query for [[IdProduct]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduct()
    {
        return $this->hasOne(Products::class, ['Id' => 'IdProduct']);
    }
}

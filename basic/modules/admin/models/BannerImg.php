<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "banner_img".
 *
 * @property int $Id
 * @property int $IdBanner
 * @property string $Title
 * @property string $Link
 * @property string $Img
 *
 * @property Banner $idBanner
 */
class BannerImg extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banner_img';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdBanner', 'Title', 'Link', 'Img'], 'required'],
            [['IdBanner'], 'integer'],
            [['Title', 'Link', 'Img'], 'string', 'max' => 500],
            ['Img', 'image', 'extensions' => 'png, jpg, gif'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif'],
            [['IdBanner'], 'exist', 'skipOnError' => true, 'targetClass' => Banner::class, 'targetAttribute' => ['IdBanner' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'IdBanner' => Yii::t('app', 'Название слайдера'),
            'Title' => Yii::t('app', 'Описание'),
            'Link' => Yii::t('app', 'Ссылка'),
            'Img' => Yii::t('app', 'Изображения'),
            'imageFile' => 'Загрузить',
        ];
    }

    /**
     * Gets query for [[IdBanner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdBanner()
    {
        return $this->hasOne(Banner::class, ['Id' => 'IdBanner']);
    }
}

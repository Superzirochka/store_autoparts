<?php

namespace app\models;

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
            [['IdBanner'], 'exist', 'skipOnError' => true, 'targetClass' => Banner::className(), 'targetAttribute' => ['IdBanner' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'IdBanner' => 'Id Banner',
            'Title' => 'Title',
            'Link' => 'Link',
            'Img' => 'Img',
        ];
    }

    /**
     * Gets query for [[IdBanner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdBanner()
    {
        return $this->hasOne(Banner::className(), ['Id' => 'IdBanner']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property int $Id
 * @property string $Name
 * @property int $Status
 *
 * @property BannerImg[] $bannerImgs
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['Status'], 'integer'],
            [['Name'], 'string', 'max' => 150],
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
            'Status' => 'Status',
        ];
    }

    /**
     * Gets query for [[BannerImgs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBannerImgs()
    {
        return $this->hasMany(BannerImg::className(), ['IdBanner' => 'Id']);
    }
}

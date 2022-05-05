<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\models\BannerImg;

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
            'Id' => Yii::t('app', 'ID'),
            'Name' => Yii::t('app', 'Название'),
            'Status' => Yii::t('app', 'Статус'),
        ];
    }
    public function beforeDelete()
    {
        $products = BannerImg::find()->where(['IdBanner' => $this->Id])->all();
        if (!empty($products)) {
            Yii::$app->session->setFlash(
                'warning',
                'Нельзя удалить слайдер, у которого есть изображения'
            );
            return false;
        }
        return parent::beforeDelete();
    }
    /**
     * Gets query for [[BannerImgs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBannerImgs()
    {
        return $this->hasMany(BannerImg::class, ['IdBanner' => 'Id']);
    }
}

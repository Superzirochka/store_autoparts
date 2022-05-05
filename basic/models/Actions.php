<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actions".
 *
 * @property int $Id
 * @property string $Name
 * @property string $Slug
 * @property string $Content
 * @property string $Img
 * @property string $KeyWord
 * @property string $MetaDescription
 * @property string $DateAdd
 */
class Actions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name', 'Slug', 'Content', 'Img', 'KeyWord', 'MetaDescription', 'DateAdd'], 'required'],
            [['Content'], 'string'],
            [['DateAdd'], 'safe'],
            [['Name', 'Slug'], 'string', 'max' => 150],
            [['Img'], 'string', 'max' => 250],
            [['KeyWord'], 'string', 'max' => 170],
            [['MetaDescription'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Name' => Yii::t('app', 'Name'),
            'Slug' => Yii::t('app', 'Slug'),
            'Content' => Yii::t('app', 'Content'),
            'Img' => Yii::t('app', 'Img'),
            'KeyWord' => Yii::t('app', 'Key Word'),
            'MetaDescription' => Yii::t('app', 'Meta Description'),
            'DateAdd' => Yii::t('app', 'Date Add'),
        ];
    }
}

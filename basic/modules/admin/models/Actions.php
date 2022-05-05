<?php

namespace app\modules\admin\models;

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
 */
class Actions extends \yii\db\ActiveRecord
{
    public $imageFile;
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
            [['Name', 'Slug'], 'string', 'max' => 150],
            [['Img'], 'string', 'max' => 250],
            [['KeyWord'], 'string', 'max' => 170],
            [['MetaDescription'], 'string', 'max' => 255],
            [['DateAdd'], 'safe'],
            ['Img', 'image', 'extensions' => 'png, jpg, gif'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Name' => Yii::t('app', 'Заголовок'),
            'Slug' => Yii::t('app', 'Для создания ссылки'),
            'Content' => Yii::t('app', 'Содержимое страницы'),
            'Img' => Yii::t('app', 'Картинка'),
            'KeyWord' => Yii::t('app', 'Мета-тег keywords'),
            'MetaDescription' => Yii::t('app', 'Мета-тег description'),
            'DateAdd' => Yii::t('app', 'Дата добавления'),
            'imageFile' => 'Загрузить',
        ];
    }
}

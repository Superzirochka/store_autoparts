<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property int $Id
 * @property string $Name_shop
 * @property string $Description
 * @property string $Meta_title
 * @property string $Meta_description
 * @property string $Meta_keyword
 * @property string $Phone
 * @property string $Viber
 * @property string $Facebook_link
 * @property string $Work_time
 * @property string $Email
 * @property string $Adress
 * @property string $Date_add
 * @property string $Owner
 * @property string $Telegram_link
 * @property string $Google_map
 * @property string $Logo
 * @property string $logo_small
 * @property int $Id_lang
 * @property string|null $About
 * @property string|null $Dostavka
 * @property string|null $Oplata
 * @property string|null $Vozvrat
 * @property string|null $Confiden
 * @property string|null $Description_ua
 * @property string|null $Meta_title_ua
 * @property string|null $Meta_description_ua
 * @property string|null $Meta_keyword_ua
 * @property string|null $Work_time_ua
 * @property string|null $Adress_ua
 * @property string|null $About_ua
 * @property string|null $Dostavka_ua
 * @property string|null $Oplata_ua
 * @property string|null $Vozvrat_ua
 * @property string|null $Confiden_ua
 *
 * @property Lang $lang
 */
class Store extends \yii\db\ActiveRecord
{

    public $logoSmall;
    public $logoBig;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name_shop', 'Description', 'Meta_title', 'Meta_description', 'Meta_keyword', 'Phone', 'Viber', 'Facebook_link', 'Work_time', 'Email', 'Adress', 'Date_add', 'Owner', 'Telegram_link', 'Google_map', 'Logo', 'logo_small', 'Id_lang'], 'required'],
            [['Date_add'], 'safe'],
            [['Id_lang'], 'integer'],
            [['Name_shop', 'Meta_description', 'Meta_keyword', 'Phone', 'Email', 'Owner', 'Meta_description_ua', 'Meta_keyword_ua'], 'string', 'max' => 250],
            [[
                'Description', 'Facebook_link', 'Work_time', 'Adress', 'Telegram_link', 'Google_map',
                // 'Logo', 'logo_small', 
                'Description_ua', 'Work_time_ua', 'Adress_ua'
            ], 'string', 'max' => 500],
            [['Info'], 'string', 'max' => 1000],
            [['Logo', 'logo_small'], 'image', 'extensions' => 'png, jpg, gif'],
            [['Meta_title', 'Meta_title_ua'], 'string', 'max' => 170],
            [['Viber'], 'string', 'max' => 17],
            [['Id_lang'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::class, 'targetAttribute' => ['Id_lang' => 'Id']],
            [['logoSmall'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif'],
            [['logoBig'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Name_shop' => Yii::t('app', 'Название магазина'),
            'Description' => Yii::t('app', 'Описание'),
            'Meta_title' => Yii::t('app', 'Meta Title'),
            'Meta_description' => Yii::t('app', 'Meta Description'),
            'Meta_keyword' => Yii::t('app', 'Meta Keyword'),
            'Phone' => Yii::t('app', 'Контактный телефон'),
            'Viber' => Yii::t('app', 'Viber'),
            'Facebook_link' => Yii::t('app', 'Ссылка на Facebook'),
            'Work_time' => Yii::t('app', 'Время работы'),
            'Email' => Yii::t('app', 'Email'),
            'Adress' => Yii::t('app', 'Адрес'),
            'Date_add' => Yii::t('app', 'Date Add'),
            'Owner' => Yii::t('app', 'Владелец'),
            'Telegram_link' => Yii::t('app', 'Ссылка на Telegram'),
            'Google_map' => Yii::t('app', 'Google Map'),
            'Logo' => Yii::t('app', 'Logo'),
            'logo_small' => Yii::t('app', 'Logo Small'),
            'Id_lang' => Yii::t('app', 'Id Lang'),
            'Description_ua' => Yii::t('app', 'Опис'),
            'Meta_title_ua' => Yii::t('app', 'Meta Title Ua'),
            'Meta_description_ua' => Yii::t('app', 'Meta Description Ua'),
            'Meta_keyword_ua' => Yii::t('app', 'Meta Keyword Ua'),
            'Work_time_ua' => Yii::t('app', 'Час роботи Ua'),
            'Adress_ua' => Yii::t('app', 'Adress Ua'),
            'logoBig' => Yii::t('app', 'Logo'),
            'logoSmall' => Yii::t('app', 'Logo Small'),
            'Info' => Yii::t('app', 'Информация'),
        ];
    }

    /**
     * Gets query for [[Lang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::class, ['Id' => 'Id_lang']);
    }
}

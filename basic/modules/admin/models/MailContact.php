<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "mail_contact".
 *
 * @property int $Id
 * @property string $FIO
 * @property string $TitleMessage
 * @property string $Message
 * @property string $Email
 * @property string $Status
 * @property string $DateAdd
 */
class MailContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mail_contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FIO', 'TitleMessage', 'Message', 'Email', 'DateAdd'], 'required'],
            [['DateAdd'], 'safe'],
            [['FIO'], 'string', 'max' => 500],
            [['TitleMessage'], 'string', 'max' => 250],
            [['Message'], 'string', 'max' => 1000],
            [['Email'], 'string', 'max' => 150],
            [['Status'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'FIO' => Yii::t('app', 'ФИО отправителя'),
            'TitleMessage' => Yii::t('app', 'Загаловок'),
            'Message' => Yii::t('app', 'Сообщение'),
            'Email' => Yii::t('app', 'Электронная почта'),
            'Status' => Yii::t('app', 'Статус'),
            'DateAdd' => Yii::t('app', 'Дата отправления'),
        ];
    }
}

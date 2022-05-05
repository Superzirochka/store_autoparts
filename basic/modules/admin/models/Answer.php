<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property int $Id
 * @property int $IdMailContakt
 * @property string $Title
 * @property string $Text
 * @property string $DateAnswer
 *
 * @property MailContact $idMailContakt
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdMailContakt', 'Title', 'Text', 'DateAnswer'], 'required'],
            [['IdMailContakt'], 'integer'],
            [['Text'], 'string'],
            [['DateAnswer'], 'safe'],
            [['Title'], 'string', 'max' => 250],
            [['IdMailContakt'], 'exist', 'skipOnError' => true, 'targetClass' => MailContact::class, 'targetAttribute' => ['IdMailContakt' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'IdMailContakt' => Yii::t('app', 'Номер сообщения'),
            'Title' => Yii::t('app', 'Заголовок'),
            'Text' => Yii::t('app', 'Текст ответа'),
            'DateAnswer' => Yii::t('app', 'Дата ответа'),
        ];
    }

    /**
     * Gets query for [[IdMailContakt]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdMailContakt()
    {
        return $this->hasOne(MailContact::class, ['Id' => 'IdMailContakt']);
    }
}

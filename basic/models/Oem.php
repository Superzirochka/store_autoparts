<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oem".
 *
 * @property int $Id
 * @property string $OEM
 * @property int $IdNode
 * @property int $Id_auto
 * @property string|null $Img
 * @property string|null $Description_ua
 * @property string|null $Description
 *
 * @property NodeAuto $idNode
 * @property Modification $auto
 */
class Oem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OEM', 'IdNode', 'Id_auto'], 'required'],
            [['IdNode', 'Id_auto'], 'integer'],
            [['OEM', 'Img'], 'string', 'max' => 500],
            [['Description_ua', 'Description'], 'string', 'max' => 5000],
            [['OEM'], 'unique'],
            [['IdNode'], 'exist', 'skipOnError' => true, 'targetClass' => NodeAuto::class, 'targetAttribute' => ['IdNode' => 'Id']],
            [['Id_auto'], 'exist', 'skipOnError' => true, 'targetClass' => Modification::class, 'targetAttribute' => ['Id_auto' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'OEM' => Yii::t('app', 'Oem'),
            'IdNode' => Yii::t('app', 'Id Node'),
            'Id_auto' => Yii::t('app', 'Id Auto'),
            'Img' => Yii::t('app', 'Img'),
            'Description_ua' => Yii::t('app', 'Description Ua'),
            'Description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * Gets query for [[IdNode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdNode()
    {
        return $this->hasOne(NodeAuto::class, ['Id' => 'IdNode']);
    }

    /**
     * Gets query for [[Auto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuto()
    {
        return $this->hasOne(Modification::class, ['Id' => 'Id_auto']);
    }
}

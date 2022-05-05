<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "modification".
 *
 * @property int $Id
 * @property int $IdModelAuto
 * @property int $IdEngine
 * @property int $IdValueEngine
 *
 * @property Engine $idEngine
 * @property ModelAuto $idModelAuto
 * @property ValueEngine $idValueEngine
 * @property Oem[] $oems
 */
class Modification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdModelAuto', 'IdEngine', 'IdValueEngine'], 'required'],
            [['IdModelAuto', 'IdEngine', 'IdValueEngine'], 'integer'],
            [['IdEngine'], 'exist', 'skipOnError' => true, 'targetClass' => Engine::class, 'targetAttribute' => ['IdEngine' => 'Id']],
            [['IdModelAuto'], 'exist', 'skipOnError' => true, 'targetClass' => ModelAuto::class, 'targetAttribute' => ['IdModelAuto' => 'Id']],
            [['IdValueEngine'], 'exist', 'skipOnError' => true, 'targetClass' => ValueEngine::class, 'targetAttribute' => ['IdValueEngine' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'IdModelAuto' => Yii::t('app', 'Модель'),
            'IdEngine' => Yii::t('app', 'Топливо'),
            'IdValueEngine' => Yii::t('app', 'Объем двигателя'),
        ];
    }

    /**
     * Gets query for [[IdEngine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEngine()
    {
        return $this->hasOne(Engine::class, ['Id' => 'IdEngine']);
    }

    /**
     * Gets query for [[IdModelAuto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdModelAuto()
    {
        return $this->hasOne(ModelAuto::class, ['Id' => 'IdModelAuto']);
    }

    /**
     * Gets query for [[IdValueEngine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdValueEngine()
    {
        return $this->hasOne(ValueEngine::class, ['Id' => 'IdValueEngine']);
    }

    /**
     * Gets query for [[Oems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOems()
    {
        return $this->hasMany(Oem::className(), ['Id_auto' => 'Id']);
    }
}

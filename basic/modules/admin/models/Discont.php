<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "discont".
 *
 * @property int $Id
 * @property int $Value_discont
 *
 * @property Products[] $products
 */
class Discont extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discont';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Value_discont'], 'required'],
            [['Value_discont'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Value_discont' => Yii::t('app', 'Value Discont'),
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['Id_discont' => 'Id']);
    }
}

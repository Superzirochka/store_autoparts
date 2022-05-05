<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "current".
 *
 * @property int $Id
 * @property string $Name
 * @property string $Small_name
 * @property string $course
 *
 * @property Products[] $products
 */
class Current extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'current';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name', 'Small_name'], 'required'],
            [['Name'], 'string', 'max' => 150],
            [['Small_name'], 'string', 'max' => 10],
            [['course'], 'string', 'max' => 15],
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
            'Small_name' => 'Small Name',
            'course' => 'Course',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['Id_current' => 'Id']);
    }
}

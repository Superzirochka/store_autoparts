<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $Id
 * @property int $Id_Costome
 * @property int $IdProduct
 * @property string $Title
 * @property string $Review
 * @property int $Raiting
 * @property string $Date_add
 *
 * @property Customers $costome
 * @property Products $idProduct
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id_Costome', 'IdProduct', 'Title', 'Review', 'Raiting', 'Date_add'], 'required'],
            [['Id_Costome', 'IdProduct', 'Raiting'], 'integer'],
            [['Date_add'], 'safe'],
            [['Title'], 'string', 'max' => 250],
            [['Review'], 'string', 'max' => 1000],
            [['Id_Costome'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::className(), 'targetAttribute' => ['Id_Costome' => 'Id']],
            [['IdProduct'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['IdProduct' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Id_Costome' => 'Id Costome',
            'IdProduct' => 'Id Product',
            'Title' => 'Title',
            'Review' => 'Review',
            'Raiting' => 'Raiting',
            'Date_add' => 'Date Add',
        ];
    }

    /**
     * Gets query for [[Costome]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCostome()
    {
        return $this->hasOne(Customers::className(), ['Id' => 'Id_Costome']);
    }

    /**
     * Gets query for [[IdProduct]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduct()
    {
        return $this->hasOne(Products::className(), ['Id' => 'IdProduct']);
    }
}
